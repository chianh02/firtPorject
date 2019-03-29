<?php
#encoding: utf-8
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Slide;

class IndexController extends Controller
{
  //before_action :get_mobile_or_not, :only=>[:index,:home]
  /**
   * Instantiate a new controller instance.
     *
     * @return void
   */
  public function __construct()
  {
    $this->middleware('mobileornot');

    // chi dung cho ham index
    //$this->middleware('log')->only('index');
    
    // khong dung cho ham store
    //$this->middleware('subscribed')->except('store');
  }
  
  function index()
  {  
    $subjects = Subject::where("parent_id = 0")->orderBy('sort','asc');
    $slide = Slide::order('created_at','desc')->limit(3);
    //respond_to do |format|
    //  format.html # index.html.erb
    //end
    return view('viewName', compact('subjects','slide'));
  }

  function home()
  {
    //if (mobile_device ==false)
    //{
      $subjects = Subject::where("parent_id = 0")->orderBy('sort','asc');
	    //if(fragment_exist?("slide_#{session[:lang]}"))
      //{
		    $slide = Slide::orderBy('created_at','desc')->limit(3);
      //}
    //}
    /*respond_to do |format|
      format.html # index.html.erb
    end  */

    return view('index/home', compact('subjects','slide'));
  }
}
