<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\PdsCourse;
class PdsController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth:pdg');
    }

     public function index()
    {
    	return view('Pds.index');
    }

    public function pds_view_result()
{

 
    $s=session()->get('session_year');
   $course =PdsCourse::get();
    return view('pds.pds_view_result')->withSs($s)->withCc($course);
}
}
