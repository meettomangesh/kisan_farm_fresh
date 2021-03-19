<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Helper\DataHelper;
use App\Role;
use Carbon\Carbon;

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
            'email_address' => 'unique:users,email',
            'mobile_number' => 'required|unique:users,mobile_number',
            'password' => 'required',
            //  'confirm_password' => 'required|same:password',
            'otp_verified' => 'required',
            'pin_code' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError(parent::VALIDATION_ERROR, $validator->errors());
        }

        $input = $request->all();
        $input['email'] = $request->email_address;
        $input['password'] = bcrypt($input['password']);
        $input['referral_code'] = DataHelper::generateBarcodeString(9);
        $input['email_verify_key'] = DataHelper::emailVerifyKey();
        $input['created_by'] = 1;
        $input['roles'] = [4];

        $user = User::create($input);
        $user->roles()->sync([4]);
        $tokenResult = $user->createToken(getenv('APP_NAME'));
        $tokenResult->token->expires_at = Carbon::now()->addDays(10);
        $success['token'] =  $tokenResult->accessToken;
        $success['expires_at'] =  $tokenResult->token->expires_at;

        // $success['token'] =  $user->createToken(getenv('APP_NAME'))->accessToken;
        $success['name'] =  $user->first_name . " " . $user->last_name;
        $success['id'] = $user->id;
        $success['role'] = $user->load('roles')->roles[0]->id;
        $success['role_name'] = $user->load('roles')->roles[0]->title;

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function updateCustomer(Request $request)
    {
        if (!isset($request->role_id)) {
            return $this->sendError("Please provide valid role details.", []);
        }

        if ($request->role_id == 3) { // For delivery boys only
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email_address' => 'email|unique:users,email,' . $request->id,
                'id' => 'required',
                'role_id' => 'required',
                'platform' => 'required',
                'aadhar_number' => 'required',
                'pan_number' => 'required',
                'license_number' => 'required',
                'vehicle_type' => 'required',
                'vehicle_number' => 'required',
                'user_photo' => 'required',
                'aadhar_card_photo' => 'required',
                'pan_card_photo' => 'required',
                'license_card_photo' => 'required',
                'rc_book_photo' => 'required',
                'bank_name' => 'required',
                'account_number' => 'required',
                'ifsc_code' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'date_of_birth' => 'required',
                'marital_status' => 'required',
                'email_address' => 'email|unique:users,email,' . $request->id,
                'id' => 'required',
                'role_id' => 'required',
                'platform' => 'required'
            ]);
        }


        if ($validator->fails()) {
            return $this->sendError(parent::VALIDATION_ERROR, $validator->errors());
        }

        $input = $request->all();
        $customer = User::where('id', $request->id)->first();
        $input['email'] = $request->email_address;
        //  $input['password'] = bcrypt($input['password']);
        //$input['referral_code'] = DataHelper::generateBarcodeString(9);
        //$input['email_verify_key'] = DataHelper::emailVerifyKey();

        if (!$customer) {
            return $this->sendError("Please try with valid details.", []);
        }

        $input['updated_by'] = 1;
        $customer->update($input);

        if ($request->role_id == 3) {
            $userDetails =  UserDetails::updateOrCreate(
                ['user_id' => $request->id, 'role_id' => $request->role_id],
                $input
            );
        }

        //$customer = User::create($input);
        // $success['token'] =  $customer->createToken(getenv('APP_NAME'))->accessToken;
        $success['name'] =  $customer->first_name . " " . $customer->last_name;
        $success['id'] = $customer->id;
        $success['role'] = $customer->load('roles')->roles[0]->id;
        $success['role_name'] = $customer->load('roles')->roles[0]->title;
        $message = 'User updated successfully.';
        switch ($request->role_id) {
            case 3:
                $message = 'Delivery boy data updated successfully.';
                break;
            case 4:
                $message = 'Customer data updated successfully.';
                break;
            default:
                $message = 'User updated successfully.';
                break;
        }
        return $this->sendResponse($success, $message);
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

        // if (Auth::guard('api')->attempt(['mobile_number' => $request->mobile_number, 'password' => $request->password])) {
        if (Auth::attempt(['mobile_number' => $request->mobile_number, 'password' => $request->password])) {
            // $credentials = request(['email', 'password']);
            // if(!Auth::attempt($credentials))
            //     return response()->json([
            //         'message' => 'Unauthorized'
            //     ], 401);

            $user = Auth::user();
            //print_r($user->createToken(getenv('APP_NAME'))); exit;
            //$token = $user->createToken(getenv('APP_NAME'));
            $tokenResult = $user->createToken(getenv('APP_NAME'));
            $tokenResult->token->expires_at = Carbon::now()->addDays(10);
            $success['token'] =  $tokenResult->accessToken;
            $success['expires_at'] =  $tokenResult->token->expires_at;
            $success['name'] =  $user->first_name . " " . $user->last_name;
            $success['dob'] =  $user->date_of_birth;
            $success['marital_status'] =  $user->marital_status;
            $success['gender'] =  $user->gender;
            $success['email'] =  $user->email;
            $success['id'] = $user->id;
            $success['role'] = $user->load('roles')->roles[0]->id;
            $success['role_name'] = $user->load('roles')->roles[0]->title;
            $userDetails = $user->details;
            unset($userDetails->id);
            unset($userDetails->user_id);
            unset($userDetails->role_id);
            $success['details'] = ($user->details) ? $user->details : (object)[];
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
