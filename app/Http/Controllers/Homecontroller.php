<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class Homecontroller extends Controller
{
    public function index()
    {
        $categories= Category::limit(10)->get();
        $slidercategories= Category::limit(5)->get();
        return view('home',[
            'categories'=>$categories, 
            'slidercategories'=>$slidercategories, 
            
        ]);
    }
}
