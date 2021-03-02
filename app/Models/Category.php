<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Category extends Model
{
    use SoftDeletes;

    public $table = 'categories_master';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = ['cat_name','cat_image_name','status','cat_description','created_by','updated_by','created_at','updated_at','deleted_at'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected function storeCategory($params) {
        $image = $params->file('cat_image_name');
        $inputs = $params->all();
        $path = '/images/categories/';
        $var = date_create();
        $time = date_format($var, 'YmdHis');
        $imageName = $time . '-' . $image->getClientOriginalName();
        $image->move(base_path().'/public' . $path, $imageName);
        Category::create(array(
            'cat_name' => $inputs['cat_name'],
            'cat_image_name' => $path.$imageName,
            'cat_description' => $inputs['cat_description'],
            'status' => $inputs['status'],
            'created_by' => $inputs['created_by']
        ));
    }

    protected function updateCategory($params, $category) {
        $inputs = $params->all();
        $imageName = $category->cat_image_name;
        if ($params->hasFile('cat_image_name')) {
            $image = $params->file('cat_image_name');
            $path = '/images/categories/';
            $var = date_create();
            $time = date_format($var, 'YmdHis');
            $imageName = $time . '-' . $image->getClientOriginalName();
            $image->move(base_path().'/public' . $path, $imageName);
            $imageName = $path.$imageName;
            if(file_exists(public_path($category->cat_image_name))) {
                unlink(public_path($category->cat_image_name));
            }
        }
        $category = Category::find($category->id);
        $category->cat_name = $inputs['cat_name'];
        $category->cat_image_name = $imageName;
        $category->cat_description = $inputs['cat_description'];
        $category->status = $inputs['status'];
        $category->updated_by = $inputs['updated_by'];
        $category->save();
        return true;
    }

    public function getCategoryList() {
        return Category::select('id','cat_name','cat_image_name')->where('status', 1)->get()->toArray();
    }

    protected function getCategoryName($id) {
        $categoryName = Category::select('cat_name')->where('id', $id)->where('status', 1)->get()->toArray();
        return $categoryName[0]['cat_name'];
    }
}