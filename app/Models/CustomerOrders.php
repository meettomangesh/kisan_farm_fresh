<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use App\User;
use App\Models\CustomerOrderDetails;
use App\Models\CustomerOrderStatusTrack;
use App\Models\ProductLocationInventory;
use App\Models\UserAddress;
use DB;
use PDO;

class CustomerOrders extends Model
{
    use SoftDeletes;

    public $table = 'customer_orders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = ['customer_id','delivery_boy_id','shipping_address_id','billing_address_id','delivery_date','net_amount','gross_amount','discounted_amount','payment_type','payment_id','total_items','total_items_quantity','reject_cancel_reason','purchased_from','is_coupon_applied','is_basket_in_order','order_status','created_by','updated_by','created_at','updated_at'];

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

    public function customerShippingAddress()
    {
        return $this->belongsTo(UserAddress::class, 'shipping_address_id');
    }

    public function customerBillingAddress()
    {
        return $this->belongsTo(UserAddress::class, 'billing_address_id');
    }

    public function orderDetails() {
        return $this->hasMany(CustomerOrderDetails::class, 'order_id');
    }

    protected function cancelOrder($orderId, $type) {
        $cancelData = array('order_id' => $orderId, 'type' => $type);
        $inputData = json_encode($cancelData);
        $pdo = DB::connection()->getPdo();
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $stmt = $pdo->prepare("CALL cancelOrder(?)");
        $stmt->execute([$inputData]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt->closeCursor();
        $reponse = json_decode($result['response']);
        if($reponse->status == "FAILURE" && $reponse->statusCode != 200) {
            return false;
        }
        return true;
        /* $statusCancelled = 5;
        $statusIds = explode(',', '1');        
        $codData = CustomerOrderDetails::select('id','product_units_id','item_quantity','is_basket')->where('order_id', $orderId)->whereIn('order_status', $statusIds)->get()->toArray();
        if(sizeof($codData) > 0) {
            foreach($codData as $key => $value) {
                if($type == 1) {
                    CustomerOrderDetails::where('id', $value['id'])->forceDelete();
                    CustomerOrderStatusTrack::where('order_details_id', $value['id'])->forceDelete();
                } else {
                    $cod = CustomerOrderDetails::find($value['id']);
                    $cod->order_status = $statusCancelled;
                    $cod->save();
                    CustomerOrderStatusTrack::create(array(
                        'order_details_id' => $value['id'],
                        'order_status' => $statusCancelled,
                        'created_by' => 1
                    ));
                }
                $qty = ProductLocationInventory::select('id','current_quantity')->where('product_units_id', $value['product_units_id'])->get()->toArray();
                $inventory = ProductLocationInventory::find($qty[0]['id']);
                $inventory->current_quantity = $qty[0]['current_quantity'] + $value['item_quantity'];
                $inventory->save();
            }
            if($type == 1) {
                $co = CustomerOrders::find($orderId);
                $co->forceDelete();
            } else {
                $co = CustomerOrders::find($orderId);
                $co->order_status = $statusCancelled;
                $co->save();
            }
            return true;
        }
        return false; */
    }

    public function cancelOrderAPI($params) {
        return $this->cancelOrder($params['order_id'], 2);
    }

    public function placeOrder($params) {
        // validate customer
        $usersData = User::select('id')->where('id', $params['user_id'])->where('status', 1)->get()->toArray();
        $userAddressData = UserAddress::select('id')->where('id', $params['delivery_details']['address']['id'])->where('user_id', $params['user_id'])->where('status', 1)->get()->toArray();
        if(sizeof($usersData) == 0 || sizeof($params['products']) == 0 || sizeof($userAddressData) == 0) {
            return false;
        }
        // validate delivery date
        if($params['delivery_details']['date'] < date('Y-m-d')) {
            return false;
        }

        $orderAmount = $totalItemQty = $isBasketInOrder = 0;
        // validate product
        foreach($params['products'] as $key => $value) {
            $orderAmount = $orderAmount + ((($value['special_price'] > 0) ? $value['special_price'] : $value['selling_price']) * $value['quantity']);
            $totalItemQty = $totalItemQty + $value['quantity'];
            $inputData = json_encode($value);
            // $result = DB::select('call validateProduct(?)', [$inputData]);
            $pdo = DB::connection()->getPdo();
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $stmt = $pdo->prepare("CALL validateProduct(?)");
            $stmt->execute([$inputData]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $stmt->closeCursor();
            $reponse = json_decode($result['response']);
            if($reponse->status == "FAILURE" && $reponse->statusCode != 200) {
                return false;
            }
            if($value['is_basket'] == 1) {
                $isBasketInOrder = 1;
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
            'is_basket_in_order' => $isBasketInOrder,
            'created_by' => 1
        ));
        $orderId = $customerOrdersResponse->id;
        foreach($params['products'] as $key => $value) {
            $value['order_id'] = $orderId;
            $value['customer_id'] = $params['user_id'];
            $inputData = json_encode($value);
            /* $result = DB::select('call placeOrderDetails(?)', [$inputData]);
            $reponse = json_decode($result[0]->response); */
            $pdo = DB::connection()->getPdo();
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $stmt = $pdo->prepare("CALL placeOrderDetails(?)");
            $stmt->execute([$inputData]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $stmt->closeCursor();
            $reponse = json_decode($result['response']);
            if($reponse->status == "FAILURE" && $reponse->statusCode != 200) {
                $this->cancelOrder($orderId, 1);
                return false;
            }
        }

        // Assign delivery boy
        $assignData['order_id'] = $orderId;
        $inputData = json_encode($assignData);
        $pdo = DB::connection()->getPdo();
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $stmt = $pdo->prepare("CALL assignDeliveryBoyToOrder(?)");
        $stmt->execute([$inputData]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt->closeCursor();
        return true;
    }

    public function getOrderList($params) {
        $queryResult = DB::select('call getOrderList(?)', [$params]);
        // $result = collect($queryResult);
        $orderList = [];
        if(sizeof($queryResult) > 0) {
            foreach($queryResult as $key => $val) {
                $orders["order_id"] = $val->id;
                $orders["delivery_details"] = array(
                    "date" => $val->delivery_date,
                    "slot" => "",
                    "order_status" => $val->order_status,
                    "address" => array(
                        "name" => $val->ua_user_name,
                        "address" => $val->address,
                        "landmark" => $val->landmark,
                        "pin_code" => $val->pin_code,
                        "area" => $val->area,
                        "city_name" => $val->city_name,
                        "state_name" => $val->state_name,
                        "is_primary" => $val->is_primary,
                        "mobile_number" => $val->mobile_number
                    ),
                    "delivery_boy_name" => $val->delivery_boy_name
                );
                $orders["payment_details"] = array(
                    "type" => $val->payment_type,
                    "net_amount" => round($val->net_amount, 2),
                    "gross_amount" => round($val->gross_amount, 2),
                    "discounted_amount" => round($val->discounted_amount, 2),
                    "order_id" => "",
                    "bill_no" => "",
                    "total_items" => $val->total_items,
                );
                $orderList[$key] = $orders;
                $inputData = array('order_id' => $val->id, 'user_id' => $val->customer_id);
                $inputData = json_encode($inputData);
                $orderDetails = DB::select('call getOrderDetails(?)', [$inputData]);
                if(sizeof($orderDetails) > 0) {
                    $orderList[$key]["products"] = $orderDetails;
                } else {
                    unset($orderList[$key]);
                }
            }
        }
        return $orderList;
    }

    public function getOrderListForDeliveryBoy($params) {
        $queryResult = DB::select('call getOrderListForDeliveryBoy(?)', [$params]);
        // $result = collect($queryResult);
        $orderList = [];
        if(sizeof($queryResult) > 0) {
            foreach($queryResult as $key => $val) {
                $orders["order_id"] = $val->id;
                $orders["delivery_details"] = array(
                    "date" => $val->delivery_date,
                    "slot" => "",
                    "order_status" => $val->order_status,
                    "address" => array(
                        "name" => $val->ua_user_name,
                        "address" => $val->address,
                        "landmark" => $val->landmark,
                        "pin_code" => $val->pin_code,
                        "area" => $val->area,
                        "city_name" => $val->city_name,
                        "state_name" => $val->state_name,
                        "is_primary" => $val->is_primary,
                        "mobile_number" => $val->mobile_number
                    ),
                    "delivery_boy_name" => $val->delivery_boy_name
                );
                $orders["payment_details"] = array(
                    "type" => $val->payment_type,
                    "net_amount" => round($val->net_amount, 2),
                    "gross_amount" => round($val->gross_amount, 2),
                    "discounted_amount" => round($val->discounted_amount, 2),
                    "order_id" => "",
                    "bill_no" => "",
                    "total_items" => $val->total_items,
                );
                $orderList[$key] = $orders;
                $inputData = array('order_id' => $val->id, 'user_id' => $val->customer_id);
                $inputData = json_encode($inputData);
                $orderDetails = DB::select('call getOrderDetails(?)', [$inputData]);
                if(sizeof($orderDetails) > 0) {
                    $orderList[$key]["products"] = $orderDetails;
                } else {
                    unset($orderList[$key]);
                }
            }
        }
        return $orderList;
    }
}
