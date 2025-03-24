<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RetrievedController extends Controller
{
    public function getResult()
    {
        $customerJson   = Storage::disk('local')->get('customer.json');
        $dealerJson     = Storage::disk('local')->get('dealer.json');


        $customerData   = json_decode($customerJson, true);
        $dealerData     = json_decode($dealerJson, true);

        // return $customerData['data'];
        // return $dealerData['data'];

        $mapCustomers   = [];

        foreach ($customerData['data'] as $customers) {

            foreach ($dealerData['data'] as $dealers) {
                if ($customers['booking']['workshop']['code'] == $dealers['code']) {
                    $mapCustomers[] = [
                        'name'                  => $customers['name'],
                        'email'                 => $customers['email'],
                        'booking_number'        => $customers['booking']['booking_number'],
                        'book_date'             => $customers['booking']['book_date'],
                        "ahass_code"            => $customers['booking']['workshop']['code'],
                        "ahass_name"            => $customers['booking']['workshop']['name'],
                        "ahass_address"         => $dealers['address'],
                        "ahass_contact"         => $dealers['phone_number'],
                        "ahass_distance"        => $dealers['distance'],
                        "motorcycle_ut_code"    => $customers['booking']['motorcycle']['ut_code'],
                        "motorcycle"            => $customers['booking']['motorcycle']['name'],
                    ];
                }
            }
        }

        return $mapCustomers;
    }
}
