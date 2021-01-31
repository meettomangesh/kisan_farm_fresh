<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class RegionDeliveryBoy extends Model
{
    use SoftDeletes;

    public $table = 'region_delivery_boy';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'region_id',
        'delivery_boy_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function pincode()
    {
        return $this->belongsTo(PinCode::class, 'delivery_boy_id');
    }
}
