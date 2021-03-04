<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use App\User;
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

    protected function cancelOrder($orderId) {
        $cancelData = array('order_id' => $orderId, 'type' => 2);
        $cancelData = json_encode($cancelData);
        $result = DB::select('call cancelOrder(?)', [$cancelData]);
        $reponse = json_decode($result[0]->response);
        if($reponse->status == "FAILURE" && $reponse->statusCode != 200) {
            return false;
        }
        return true;
    }
}
