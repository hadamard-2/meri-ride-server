<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public function checkDriverExists(Request $request)
    {
        $rules = [
            'phone_number' => 'required|digits:10',
        ];

        $messages = [
            'phone_number.required' => 'Phone number is required.',
            'phone_number.digits' => 'Phone number must be exactly 10 digits long.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400); // HTTP 400 Bad Request
        }

        $driver = Driver::where('phone_number', $request->input('phone_number'))->first();

        if ($driver) {
            return response()->json([
                'status' => 'success',
                'message' => 'Driver found.',
            ], 200); // HTTP 200 OK
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Driver not found.',
            ], 404); // HTTP 404 Not Found
        }
    }

    public function registerDriver(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'profile_photo' => 'required|file|mimes:jpeg,jpg,png|max:5120',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone_number' => 'required|string|max:15',
            'city' => 'required|string|max:50',
            'password' => 'required|string|min:8',
            'vehicle_make' => 'required|string|max:25',
            'vehicle_model' => 'required|string|max:25',
            'vehicle_color' => 'required|string|max:25',
            'vehicle_year' => 'required|integer|min:1886|max:' . date('Y'),
            'license_number' => 'required|string|max:9',
            'license_plate' => 'required|string|max:6',
            'license_country' => 'required|string|max:50',
            'license_issue_date' => 'required|date',
            'license_expiry_date' => 'required|date|after:license_issue_date',
            'tin' => 'required|string|max:12',
            'vehicle_ownership' => 'required|file|mimes:pdf|max:5120', // 5MB
            'libre' => 'required|file|mimes:pdf|max:5120',
            'insurance' => 'required|file|mimes:pdf|max:5120',
            'business_registration' => 'required|file|mimes:pdf|max:5120',
            'business_license' => 'required|file|mimes:pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Store files
        $profilePhotoPath = $request->file('profile_photo')->store('documents');
        $vehicleOwnershipPath = $request->file('vehicle_ownership')->store('documents');
        $librePath = $request->file('libre')->store('documents');
        $insurancePath = $request->file('insurance')->store('documents');
        $businessRegistrationPath = $request->file('business_registration')->store('documents');
        $businessLicensePath = $request->file('business_license')->store('documents');

        // Save driver data to the database
        $driver = Driver::create([
            'profile_photo' => $profilePhotoPath,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone_number' => $request->input('phone_number'),
            'city' => $request->input('city'),
            'password' => bcrypt($request->input('password')),
            'vehicle_make' => $request->input('vehicle_make'),
            'vehicle_model' => $request->input('vehicle_model'),
            'vehicle_color' => $request->input('vehicle_color'),
            'vehicle_year' => $request->input('vehicle_year'),
            'license_number' => $request->input('license_number'),
            'license_plate' => $request->input('license_plate'),
            'license_country' => $request->input('license_country'),
            'license_issue_date' => $request->input('license_issue_date'),
            'license_expiry_date' => $request->input('license_expiry_date'),
            'tin' => $request->input('tin'),
            'vehicle_ownership_path' => $vehicleOwnershipPath,
            'libre_path' => $librePath,
            'insurance_path' => $insurancePath,
            'business_registration_path' => $businessRegistrationPath,
            'business_license_path' => $businessLicensePath,
        ]);

        return response()->json([
            'message' => 'Driver registered successfully!',
            'driver' => $driver,
        ], 201);
    }


    public function loginDriver(Request $request)
    {
        $rules = [
            'phone_number' => 'required|digits:10',
            'password' => 'required|string|min:6',
        ];

        $messages = [
            'phone_number.required' => 'The phone number is required.',
            'phone_number.digits' => 'The phone number must be exactly 10 digits long.',
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

        $driver = Driver::where('phone_number', $request->phone_number)->first();

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
                    'first_name' => $driver->first_name,
                    'last_name' => $driver->last_name,
                    'phone_number' => $driver->phone_number,
                ],
            ],
        ], 200);
    }
}
