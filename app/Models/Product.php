<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use App\Models\ProductImages;
use App\Models\ProductInventory;
use App\Models\ProductLocationInventory;
use App\Models\Category;
use App\Models\ProductUnits;
use DB;

class Product extends Model
{
    use SoftDeletes;

    public $table = 'products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = ['brand_id', 'category_id', 'product_name', 'short_description', 'sku', 'images', 'expiry_date', 'selling_price', 'special_price', 'special_price_start_date', 'special_price_end_date', 'current_quantity', 'min_quantity', 'max_quantity', 'max_quantity_perday_percust', 'max_quantity_perday_allcust', 'notify_for_qty_below', 'stock_availability', 'status', 'view_count','created_by','updated_by'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    protected function storeProductImages ($params, $productId, $flag) {
        $images = $params->file('product_images');
        $inputs = $params->all();
        $userId = 0;
        if($flag == 1) {
            $userId = $inputs['created_by'];
        } elseif($flag == 2) {
            $userId = $inputs['updated_by'];
        }
        if ($params->hasFile('product_images')) {
            $path = '/images/products/';
            $i = 0;
            foreach ($images as $item) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $imageName = $time . '-' . $item->getClientOriginalName();
                $item->move(base_path().'/public' . $path, $imageName);
                ProductImages::create(array(
                    'products_id' => $productId,
                    'image_name' => $path.$imageName,
                    'display_order' => $i,
                    'created_by' => $userId
                ));
                $i++;
            }
        }
        return true;
    }

    protected function storeProductInventory ($params, $productId) {
        $inputs = $params->all();
        ProductInventory::create(array(
            'products_id' => $productId,
            'quantity' => $inputs['current_quantity'],
            'created_by' => $inputs['created_by']
        ));
        return true;
    }

    protected function storeProductLocationInventory ($params, $productId) {
        $inputs = $params->all();
        ProductLocationInventory::create(array(
            'products_id' => $productId,
            'current_quantity' => $inputs['current_quantity'],
            'created_by' => $inputs['created_by']
        ));
        return true;
    }

    protected function getProductImages($productId) {
        return ProductImages::select('id','image_name')->where('products_id', $productId)->get();
    }

    protected function removeProductImages($ids) {
        $imageIds = explode(',', $ids);
        foreach($imageIds as $key => $val) {
            $prodImage = ProductImages::select('id','image_name','display_order')->where('id', $val)->get()->toArray();
            if(isset($prodImage[0]['image_name']) && file_exists(public_path($prodImage[0]['image_name']))) {
                unlink(public_path($prodImage[0]['image_name']));
            }
            ProductImages::destroy($val);
        }
        return true;
    }

    protected function storeProductUnits ($params, $productId, $flag) {
        $inputs = $params->all();
        $productUnits = $inputs['unit_ids'];
        $userId = 0;
        if($flag == 1) {
            $userId = $inputs['created_by'];
        } elseif($flag == 2) {
            $userId = $inputs['updated_by'];
        }
        foreach ($productUnits as $item) {
            ProductUnits::create(array(
                'products_id' => $productId,
                'unit_id' => $item,
                'created_by' => $userId
            ));
        }
        return true;
    }

    protected function removeProductUnits($productId) {
        ProductUnits::where('products_id',$productId)->delete();
        return true;
    }

    protected function getProductUnits($productId) {
        return ProductUnits::join('unit_master', 'unit_master.id', '=', 'product_units.unit_id')
            ->where('product_units.status', 1)
            ->where('product_units.products_id', $productId)
            ->get(['unit_master.id','unit_master.unit']);
            // ->toArray();
    }

    public function getProductList($params) {
        $queryResult = DB::select('call getProductList(?)', [$params]);
        // $result = collect($queryResult);
        if(sizeof($queryResult) > 0) {
            foreach($queryResult as $key => $val) {
                $productUnits = ProductUnits::join('unit_master', 'unit_master.id', '=', 'product_units.unit_id')
                    ->where('product_units.status', 1)
                    ->where('product_units.products_id', $val->id)
                    ->get(['unit_master.id','unit_master.unit'])
                    ->toArray();
                $queryResult[$key]->product_units = $productUnits;
                $queryResult[$key]->product_images = ProductImages::select('image_name')->where('products_id', $val->id)->where('status', 1)->get()->toArray();
            }
        }
        return $queryResult;
    }
}
