<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use App\User\CustomerOrderDetails;
use DB;

class CustomerOrderStatusTrack extends Model
{
    use SoftDeletes;

    public $table = 'customer_order_status_track';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = ['order_details_id','order_status','created_by','updated_by','created_at','updated_at'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function customerOrders()
    {
        return $this->belongsToMany(CustomerOrderDetails::class, 'order_details_id');
    }
}
