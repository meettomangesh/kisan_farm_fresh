<?php

namespace App\Http\Controllers\Admin;

// use App\Product;
use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\CustomerOrders;
use DB;

class OrdersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customerOrders = CustomerOrders::all();
        return view('admin.orders.index', compact('customerOrders'));
    }

    public function show(CustomerOrders $customerOrder)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.orders.show', compact('customerOrder'));
    }

    public function cancelOrder($orderId)
    {
        $cancelOrderResponse = CustomerOrders::cancelOrder($orderId);
        if($cancelOrderResponse) {
            $data['status'] = "Success";
        } else {
            $data['status'] = "Failure";
        }
        $data['status'] = "Success";
        return json_encode($data);
    }
}
