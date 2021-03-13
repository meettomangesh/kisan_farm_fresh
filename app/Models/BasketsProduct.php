<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class RegionUser extends Model
{
    use SoftDeletes;

    public $table = 'basket_product';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'basket_id',
        'product_unit_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    public function product()
    {
        return $this->belongsTo(ProductUnits::class, 'product_unit_id');
    }

    public function basket()
    {
        return $this->belongsTo(Basket::class, 'basket_id');
    }

    // public function pincode()
    // {
    //     return $this->belongsTo(PinCode::class, 'delivery_boy_id');
    // }
}
