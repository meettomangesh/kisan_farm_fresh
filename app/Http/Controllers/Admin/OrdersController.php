<?php

namespace App\Http\Controllers\Admin;

// use App\Product;
use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\CustomerOrders;
use App\Models\CustomerOrderDetails;
use DB;

class OrdersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customerOrders = CustomerOrders::all();
        return view('admin.orders.index', compact('customerOrders'));
    }

    public function show($orderId)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customerOrder = CustomerOrders::find($orderId);
        // $customerOrderDetails = $customerOrder->orderDetails();
        // print_r($customerOrderDetails); exit;
        $customerOrderDetails = CustomerOrderDetails::where('order_id', $orderId)->get();
        return view('admin.orders.show', compact('customerOrder','customerOrderDetails'));
    }

    public function cancelOrder($orderId)
    {
        $cancelOrderResponse = CustomerOrders::cancelOrder($orderId, 2);
        if($cancelOrderResponse) {
            $data['status'] = "Success";
        } else {
            $data['status'] = "Failure";
        }
        return json_encode($data);
    }
}
