<?php

namespace App\Http\Controllers\Admin;

// use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBasketRequest;
use App\Http\Requests\StoreBasketRequest;
use App\Http\Requests\UpdateBasketRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Basket;
use App\Models\ProductUnits;

use DB;

class BasketsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('basket_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $baskets = Basket::all()->where('is_basket',1);
        return view('admin.baskets.index', compact('baskets'));
    }

    public function create()
    {
        abort_if(Gate::denies('basket_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //$categories = Category::all()->where('status', 1)->pluck('cat_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        // $regions = Region::all()->where('status', 1)->pluck('region_name', 'id');
        $productUnits = ProductUnits::all()->where('status', 1);
        return view('admin.baskets.create', compact('categories','productUnits'));
    }

    public function store(StoreBasketRequest $request)
    {
        if ($request->hasFile('images')) {
            $basket = Basket::storeBasket($request);
            // if($product->id > 0) {
            //     Product::storeProductImages($request, $product->id, 1);
            // }
            $basket->productUnits()->sync($request->input('productUnits', []));
        }
        return redirect()->route('admin.baskets.index');
    }

    public function edit(Basket $basket)
    {
        abort_if(Gate::denies('basket_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $productImages = Product::getProductImages($product->id);
        // $srNo = 0;
        // $categories = Category::all()->where('status', 1)->pluck('cat_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        // $product->load('category');
        $productUnits = ProductUnits::all()->where('status', 1);
        $basket->load('productUnits');
        return view('admin.baskets.edit', compact('basket','productUnits'));
    }

    public function update(UpdateBasketRequest $request, Basket $basket)
    {
        $basket = Basket::updateBasket($request, $basket);
        $basket->productUnits()->sync($request->input('productUnits', []));
        return redirect()->route('admin.baskets.index');
    }

    public function show(Basket $basket)
    {
        abort_if(Gate::denies('basket_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $basket->load('productUnits');
        return view('admin.baskets.show', compact('basket'));
    }

    public function destroy(Basket $basket)
    {
        abort_if(Gate::denies('basket_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $basket->delete();
        return back();
    }

    public function massDestroy(MassDestroyBasketRequest $request)
    {
        Product::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
