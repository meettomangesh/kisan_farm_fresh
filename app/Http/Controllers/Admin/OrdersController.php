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
use App\Helper\PdfHelper;

class OrdersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customerOrders = CustomerOrders::all();
        $temp = [];
        foreach ($customerOrders as $key => $orders) {
            $temp[$key] = $orders;
            $temp[$key]->customer_invoice_url = (($temp[$key]->customer_invoice_url) ?  PdfHelper::getUplodedPath($temp[$key]->customer_invoice_url) : "");
            $temp[$key]->delivery_boy_invoice_url = (($temp[$key]->delivery_boy_invoice_url) ?  PdfHelper::getUplodedPath($temp[$key]->delivery_boy_invoice_url) : "");
        }
        $customerOrders = collect($temp);
        return view('admin.orders.index', compact('customerOrders'));
    }

    public function show($orderId)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customerOrder = CustomerOrders::find($orderId);
        $customerOrderDetails = CustomerOrderDetails::where('order_id', $orderId)->get();
        return view('admin.orders.show', compact('customerOrder', 'customerOrderDetails'));
    }
    public function reAssign($orderId)
    {
        abort_if(Gate::denies('order_reassign'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customerOrder = CustomerOrders::find($orderId);
        $customerOrderDetails = CustomerOrderDetails::where('order_id', $orderId)->get();
        return view('admin.orders.reassign', compact('customerOrder', 'customerOrderDetails'));
    }



    public function cancelOrder($orderId)
    {
        $cancelOrderResponse = CustomerOrders::cancelOrder($orderId, 2);
        if ($cancelOrderResponse) {
            $data['status'] = "Success";
        } else {
            $data['status'] = "Failure";
        }
        return json_encode($data);
    }
}
