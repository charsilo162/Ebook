<?php
namespace App\Http\Controllers;

class OrderController extends Controller
{

public function show()
        {
                if (request()->query('success')) {
                session()->flash('success', request()->query('success'));
            }
            if (request()->query('error')) {
                session()->flash('error', request()->query('error'));
            }

            return view('users.my-order');
        }

}