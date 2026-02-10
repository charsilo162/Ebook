<?php
namespace App\Http\Controllers;
class CategoryController extends Controller
{

public function show()
        {
                if (request()->query('success')) {
                session()->flash('success', request()->query('success'));
            }
            if (request()->query('error')) {
                session()->flash('error', request()->query('error'));
            }

            return view('category.category');
        }

}