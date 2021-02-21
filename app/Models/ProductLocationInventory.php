<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class ProductLocationInventory extends Model
{
    use SoftDeletes;

    public $table = 'product_location_inventory';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = ['products_id','current_quantity','created_by','updated_by'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected function getProductCurrentQuantity($productId) {
        $productCurQty = ProductLocationInventory::select('current_quantity')->where('products_id', $productId)->get()->toArray();
        return $productCurQty[0]['current_quantity'];
    }
}
