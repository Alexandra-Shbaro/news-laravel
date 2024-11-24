<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    //enforcing admin authentication 
    public function __construct()
    {
        // Ensure that only admins can access these methods
        $this->middleware('is_admin')->only(['store', 'update', 'destroy']);
    }

    //display all news 
    public function get_all_news(){
        $news= News::all();
        return response()->json($news);
    }

    //display a single news article 
    public function get_news($id){
        $news=News::findorFail($id);
        return response()->json($news);
    }
}
