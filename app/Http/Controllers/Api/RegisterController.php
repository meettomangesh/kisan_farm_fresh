<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use App\Models\CustomerLoyalty;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Helper\DataHelper;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            //'email_address' => 'required|email|unique:customer_loyalty,email_address',
            'mobile_number' => 'required|unique:customer_loyalty,mobile_number',
            'password' => 'required',
            //  'confirm_password' => 'required|same:password',
            'otp_verified' => 'required',
            'pin_code' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError(parent::VALIDATION_ERROR, $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['referral_code'] = DataHelper::generateBarcodeString(9);
        $input['email_verify_key'] = DataHelper::emailVerifyKey();
        $input['created_by'] = 1;
        $user = CustomerLoyalty::create($input);
        $success['token'] =  $user->createToken(getenv('APP_NAME'))->accessToken;
        $success['name'] =  $user->first_name . " " . $user->last_name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if (Auth::guard('api')->attempt(['mobile_number' => $request->mobile_number, 'password' => $request->password])) {
            $user = Auth::guard('api')->user();
            $success['token'] =  $user->createToken(getenv('APP_NAME'))->accessToken;
            $success['name'] =  $user->first_name . " " . $user->last_name;
            $success['dob'] =  $user->date_of_birth;
            $success['marital_status'] =  $user->marital_status;
            $success['gender'] =  $user->gender;
            $success['email'] =  $user->email_address;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function getPinCodeList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform' => 'required',
           // 'pin_code' => 'required',

        ]);
        if ($validator->fails()) {
            return $this->sendError(parent::VALIDATION_ERROR, $validator->errors());
        }

        try {
            $params = [
                'platform' => $request->platform,
                'pin_code' => $request->pin_code,

            ];
            //$params = json_encode($params);

            //Create product object to call functions
            $customer = new User();
            // Function call to get product list
            $responseDetails = $customer->getPinCodeDetails($params);
            $message = 'Pincode list.';
            if (sizeof($responseDetails) == 0) {
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
