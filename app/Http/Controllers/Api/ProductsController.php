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
            // 'category_id' => 'required',
            'no_of_records' => 'required',
            'page_number' => 'required',
            // 'search' => 'required',
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
}
