<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Exception;
use Validator;
use Carbon\Carbon;

class CategoryController extends BaseController
{

    public function getCategoryList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError(parent::VALIDATION_ERROR, $validator->errors());
        }

        try {
            //Create category object to call functions
            $category = new Category();
            // Function call to get category list
            $responseDetails = $category->getCategoryList();
            $response = $this->sendResponse($responseDetails, 'Category list.');
        } catch (Exception $e) {
            $response = $this->sendResponse(array(), $e->getMessage());
        }
        return $response;
        // $this->response->setContent(json_encode($response)); // send response in json format
    }
}
