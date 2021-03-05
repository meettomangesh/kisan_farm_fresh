<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerOrders;
use Exception;
use Validator;
use Carbon\Carbon;

class OrdersController extends BaseController
{

    public function placeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform' => 'required',
            // 'user_id' => 'exists:users.id',
            'user_id' => 'required|integer',
            'delivery_details' => 'required',
            'delivery_details.date' => 'required',
            'delivery_details.address' => 'required',
            'delivery_details.address.id' => 'required',
            'payment_details' => 'required',
            'payment_details.type' => 'in:cod,online',
            'payment_details.net_amount' => 'required|integer|gt:0',
            'payment_details.gross_amount' => 'required|integer|gt:0',
            'payment_details.discounted_amount' => 'required',
            'payment_details.order_id'=>'required_if:payment_details.type,online',
            'payment_details.transaction_id'=>'required_if:payment_details.type,online',
            'payment_details.method'=>'required_if:payment_details.type,online',
            'payment_details.bank'=>'required_if:payment_details.type,online',
            'products' => 'required',
            'products.*.id' => 'required|integer|gt:0',
            'products.*.product_unit_id' => 'required|integer|gt:0',
            'products.*.quantity' => 'required|numeric|gt:0',
            'products.*.selling_price' => 'required|gt:0',
            'products.*.special_price' => 'required',
            'products.*.special_price_start_date' => 'required_if:products.special_price,gt:0',
            'products.*.special_price_end_date' => 'required_if:products.special_price,gt:0',
            // 'products.*.expiry_date' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError(parent::VALIDATION_ERROR, $validator->errors());
        }

        try {
            $params = $request->all();
            //Create customer order object to call functions
            $customerOrders = new CustomerOrders();
            // Function call to get place order
            $responseDetails = $customerOrders->placeOrder($params);
            if($responseDetails) {
                $message = 'Order placed successully!.';
            } else {
                return $this->sendError('Failed to place order.', [], 422);
            }
            $response = $this->sendResponse([], $message);
        } catch (Exception $e) {
            $response = $this->sendResponse(array(), $e->getMessage());
        }
        return $response;
        // $this->response->setContent(json_encode($response)); // send response in json format
    }
}
