<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Torrent;
use App\Category;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('home', [
        ]);  
    }

    /**
     * Show the search cloud.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchCloud()
    {

        $terms = DB::table('search_history')->orderBy("hits", "DESC")->Limit(100)->get();
        return view('searchcloud', [
            "terms"=>$terms
        ]);  
    }


    public function recentHome()
    {

        $categories = Category::where("id", ">=", "130")->where("id", "<=", "134")->orderByRaw("id = 131 DESC")->orderByRaw("id = 132 DESC")->orderByRaw("id = 134 DESC")->orderByRaw("id = 130 DESC")->orderByRaw("id = 133 DESC")->get();


        return view('homeSearch', [
            "categories"=> $categories
        ]);  
    }

}
