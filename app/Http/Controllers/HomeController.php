<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Crypto\Crypto;



class HomeController extends Controller
{
    
    protected $crypto;   
    
    /**
     * Create a new controller instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(Crypto $crypto)
    {
        $this->crypto = $crypto;
        
    }
    /**
     * Fetch a listing of latests Currencies
     *     
     */
    public function index()
    {
      
        $currencies = $this->crypto->getLatestCurrencies();

        return view('home',compact('currencies') );
    }        
    
}
