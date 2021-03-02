<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Exception;
use Validator;
use Carbon\Carbon;

class ProductsController extends BaseController
{

    public function getProductList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform' => 'required',
            'category_id' => 'required',
            'no_of_records' => 'required',
            'page_number' => 'required',
            // 'search_value' => 'required',
            // 'sort_type' => 'required',
            // 'sort_on' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError(parent::VALIDATION_ERROR, $validator->errors());
        }

        try {
            $params = [
                'platform' => $request->platform,
                'category_id' => $request->category_id,
                'no_of_records' => $request->no_of_records,
                'page_number' => $request->page_number,
                'search_value' => $request->search_value,
                'sort_type' => $request->sort_type,
                'sort_on' => $request->sort_on,
            ];
            $params = json_encode($params);
            //Create product object to call functions
            $product = new Product();
            // Function call to get product list
            $responseDetails = $product->getProductList($params);
            $message = 'Product list.';
            if(sizeof($responseDetails) == 0) {
                $message = 'No record found.';
            }
            $response = $this->sendResponse($responseDetails, $message);
        } catch (Exception $e) {
            $response = $this->sendResponse(array(), $e->getMessage());
        }
        return $response;
        // $this->response->setContent(json_encode($response)); // send response in json format
    }

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
        exit;
        try {
            $params = [
                'platform' => $request->platform,
                'category_id' => $request->category_id,
                'no_of_records' => $request->no_of_records,
                'page_number' => $request->page_number,
                'search_value' => $request->search_value,
                'sort_type' => $request->sort_type,
                'sort_on' => $request->sort_on,
            ];
            $params = json_encode($params);
            //Create product object to call functions
            $product = new Product();
            // Function call to get product list
            $responseDetails = $product->getProductList($params);
            $message = 'Product list.';
            if(sizeof($responseDetails) == 0) {
                $message = 'No record found.';
            }
            $response = $this->sendResponse($responseDetails, $message);
        } catch (Exception $e) {
            $response = $this->sendResponse(array(), $e->getMessage());
        }
        return $response;
        // $this->response->setContent(json_encode($response)); // send response in json format
    }
}
