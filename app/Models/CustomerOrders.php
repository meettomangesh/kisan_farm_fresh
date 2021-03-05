<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use App\User;
use App\Models\CustomerOrderDetails;
use App\Models\CustomerOrderStatusTrack;
use DB;

class CustomerOrders extends Model
{
    use SoftDeletes;

    public $table = 'customer_orders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = ['customer_id','delivery_boy_id','shipping_address_id','billing_address_id','delivery_date','net_amount','gross_amount','discounted_amount','payment_type','payment_id','total_items','total_items_quantity','reject_cancel_reason','purchased_from','is_coupon_applied','order_status','created_by','updated_by','created_at','updated_at'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function userCustomer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function userDeliveryBoy()
    {
        return $this->belongsTo(User::class, 'delivery_boy_id');
    }

    protected function cancelOrder($orderId, $type) {
        /* $cancelData = array('order_id' => $orderId, 'type' => 2);
        $cancelData = json_encode($cancelData);
        $result = DB::select('call cancelOrder(?)', [$cancelData]);
        $reponse = json_decode($result[0]->response);
        if($reponse->status == "FAILURE" && $reponse->statusCode != 200) {
            return false;
        }
        return true; */
        $cancelled = 5;
        $customerOrderDetails = CustomerOrderDetails::select('id','product_units_id','item_quantity')->where('order_id', $orderId)->get()->toArray();
        if(sizeof($customerOrderDetails) > 0) {
            foreach($customerOrderDetails as $key => $value) {
                if($type == 1) {
                    CustomerOrderStatusTrack::where('order_details_id',$value['id'])->forceDelete();
                    $cod = CustomerOrderDetails::find($value['id']);
                    $cod->forceDelete();
                } else {
                    CustomerOrderStatusTrack::create(array(
                        'order_details_id' => $value['id'],
                        'order_status' => $cancelled,
                        'created_by' => 1
                    ));
                    $cod = CustomerOrderDetails::find($value['id']);
                    $cod->order_status = $cancelled;
                    $cod->save();
                }
                $qty = ProductLocationInventory::select('id','current_quantity')->where('product_units_id', $value['product_units_id'])->get()->toArray();
                $inventory = ProductLocationInventory::find($qty[0]['id']);
                $inventory->current_quantity = $qty[0]['current_quantity'] + $value['item_quantity'];
                $inventory->save();
            }
            if($type == 1) {
                $co = CustomerOrders::find($orderId);
                $co->forceDelete();
                /* //delete with primary key
                $post = Post::find(1);
                $post->delete();

                //delete with key (primary key)
                Post::destroy(1);

                //delete specific rows
                $deletedRows = Post::where('comments', 0)->delete(); */
            } else {
                $co = CustomerOrders::find($orderId);
                $co->order_status = $cancelled;
                $co->save();
            }
        }
        return true;
    }

    public function placeOrder($params) {
        // validate customer
        $usersData = User::select('id')->where('id', $params['user_id'])->where('status', 1)->get()->toArray();
        if(sizeof($usersData) == 0 || sizeof($params['products']) == 0) {
            return false;
        }
        // validate delivery date
        if($params['delivery_details']['date'] < date('Y-m-d')) {
            return false;
        }

        $orderAmount = $totalItemQty = 0;
        // validate product
        foreach($params['products'] as $key => $value) {
            $orderAmount = $orderAmount + ((($value['special_price'] > 0) ? $value['special_price'] : $value['selling_price']) * $value['quantity']);
            $totalItemQty = $totalItemQty + $value['quantity'];
            $inputData = json_encode($value);
            $result = DB::select('call validateProduct(?)', [$inputData]);
            $reponse = json_decode($result[0]->response);
            if($reponse->status == "FAILURE" && $reponse->statusCode != 200) {
                return false;
            }
        }

        if($orderAmount != $params['payment_details']['net_amount']) {
            return false;
        }

        $customerOrdersResponse = CustomerOrders::create(array(
            'customer_id' => $params['user_id'],
            'net_amount' => $params['payment_details']['net_amount'],
            'gross_amount' => $params['payment_details']['gross_amount'],
            'discounted_amount' => $params['payment_details']['discounted_amount'],
            'payment_type' => $params['payment_details']['type'],
            'total_items' => sizeof($params['products']),
            'total_items_quantity' => $totalItemQty,
            'shipping_address_id' => $params['delivery_details']['address']['id'],
            'billing_address_id' => $params['delivery_details']['address']['id'],
            'delivery_date' => $params['delivery_details']['date'],
            'created_by' => 1
        ));
        $orderId = $customerOrdersResponse->id;
        foreach($params['products'] as $key => $value) {
            $value['order_id'] = $orderId;
            $value['customer_id'] = $params['user_id'];
            $inputData = json_encode($value);
            $result = DB::select('call placeOrderDetails(?)', [$inputData]);
            $reponse = json_decode($result[0]->response);
            if($reponse->status == "FAILURE" && $reponse->statusCode != 200) {
                /* $cancelData = array('order_id' => $orderId, 'type' => 1);
                $cancelData = json_encode($cancelData);
                DB::select('call cancelOrder(?)', [$cancelData]); */
                $this->cancelOrder($orderId, 1);
                return false;
            }
        }
        return true;
    }
}
