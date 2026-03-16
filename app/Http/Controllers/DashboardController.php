<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function show()
    {
        $user = Session::get('user');
// dd($user);
        if (!$user) {
            return redirect()->route('login');
        }

        // Call API to check vendor status
        // $api = app(\App\Services\ApiService::class);
        // $response = $api->get('vendor/status');
        // //  dd( $response);
        // if (!($response['is_vendor'] ?? false)) {
        //     return redirect()->route('vendor.settings')
        //         ->with('error', 'You must complete vendor setup before accessing the dashboard. Create a BookShop');
        // }

        return view('pages.dashboard');
    }
}