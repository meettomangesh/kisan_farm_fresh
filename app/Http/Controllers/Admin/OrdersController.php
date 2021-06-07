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
        abort_if(Gate::denies('assign_order_delivery_boy'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customerOrder = CustomerOrders::find($orderId);
        $customerOrderDetails = CustomerOrderDetails::where('order_id', $orderId)->get();
        return view('admin.orders.reassign', compact('customerOrder', 'customerOrderDetails'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $customerOrder = CustomerOrders::find($id);
        $customerOrder->delivery_date = $input['delivery_date'];
        $customerOrder->update();
        return redirect()->route('admin.orders.index');
    }

    public function checkDeliveryBoyAvailability(Request $request)
    {   
        print_r($request->all()); exit;
        $params = [
            'platform' => $request->platform,
            'user_id' => $request->user_id,
            'address_id' => $request->address_id,
            'delivery_date' => $request->delivery_date,
        ];
        //Create order object to call functions
        $customerOrders = new CustomerOrders();
        // Function call to check delivery boy availability by delivery date
        $responseDetails = $customerOrders->checkDeliveryBoyAvailability($params);
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
