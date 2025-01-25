<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public function validatePhoneNum(Request $request)
    {
        $rules = [
            'phone_num' => 'required|digits:9',
        ];

        $messages = [
            'phone_num.required' => 'The phone number is required.',
            'phone_num.digits' => 'The phone number must be exactly 9 digits long.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422); // HTTP 422 Unprocessable Entity
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Phone number is valid.',
            'data' => [
                'phone_num' => $request->phone_num,
            ],
        ], 200);
    }

    public function checkDriverExists(Request $request)
    {
        $validationResult = $this->validatePhoneNum($request);

        if (is_array($validationResult) && isset($validationResult['status']) && $validationResult['status'] === 'error') {
            return response()->json($validationResult, 422);
        }

        $phoneNum = $validationResult; // The validated phone number
        $driver = Driver::where('phone_num', $phoneNum)->first();

        // Return response based on whether the driver exists
        if ($driver) {
            return response()->json([
                'status' => 'success',
                'message' => 'Driver found.',
                'data' => [
                    'driver' => $driver,
                ],
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Driver not found.',
            ], 404); // HTTP 404 Not Found
        }
    }

    public function loginDriver(Request $request)
    {
        $rules = [
            'phone_num' => 'required|digits:9',
            'password' => 'required|string|min:6',
        ];

        $messages = [
            'phone_num.required' => 'The phone number is required.',
            'phone_num.digits' => 'The phone number must be exactly 9 digits long.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 6 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422); // HTTP 422 Unprocessable Entity
        }

        $driver = Driver::where('phone_num', $request->phone_num)->first();

        // Check if the driver exists and the password is correct
        if (!$driver || !Hash::check($request->password, $driver->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'The phone number, password combination you entered was not correct.',
            ], 401); // HTTP 401 Unauthorized
        }

        // If credentials are correct, log the driver in (later use JWT for authentication)
        // For simplicity, we'll just return a success response here
        return response()->json([
            'status' => 'success',
            'message' => 'Driver logged in successfully.',
            'data' => [
                'driver' => [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'phone_num' => $driver->phone_num,
                ],
            ],
        ], 200);
    }
}
