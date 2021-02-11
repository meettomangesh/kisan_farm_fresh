<?php

namespace App\Http\Controllers\Admin;

// use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\Category;

class ProductsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::all()->pluck('cat_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        // print_r($request->all()); exit;
        if ($request->hasFile('product_images')) {
            $product = Product::create($request->all());
            if($product->id > 0) {
                Product::storeProductImages($request, $product->id, 1);
                Product::storeProductInventory($request, $product->id);
            }
        }
        return redirect()->route('admin.products.index');
    }

    public function edit(Product $product)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $productImages = Product::getProductImages($product->id);
        $srNo = 0;
        $categories = Category::all()->pluck('cat_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $product->load('category');
        return view('admin.products.edit', compact('product','productImages','srNo','categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        // print_r($request->all());exit;
        $requestAll = $request->all();
        $product->update($requestAll);
        if ($request->hasFile('product_images') && $product->id > 0) {
            Product::storeProductImages($request, $product->id, 2);
        }
        if($requestAll['removed_images'] != '' && $product->id > 0) {
            Product::removeProductImages($requestAll['removed_images']);
        }

        return redirect()->route('admin.products.index');
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $product->delete();
        return back();
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        Product::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
