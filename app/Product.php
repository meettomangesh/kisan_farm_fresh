<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Product extends Model
{
    use SoftDeletes;

    public $table = 'products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = ['brand_id', 'product_name', 'short_description', 'sku', 'images', 'expiry_date', 'selling_price', 'special_price', 'special_price_start_date', 'special_price_end_date', 'current_quantity', 'min_quantity', 'max_quantity', 'max_quantity_perday_percust', 'max_quantity_perday_allcust', 'notify_for_qty_below', 'stock_availability', 'status', 'view_count'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
