<?php

namespace App\Http\Middleware;

use App\Http\Middleware\CheckAge;
use Illuminate\Http\Request;


class BeforeApp extends Middleware
{
    /**
     * The names of the attributes that should not be trimmed.
     * before_action :get_lang
  	   before_action :get_cookie
  	   before_action :get_footer
  	   before_action :prepare_for_mobile
     * @var array
     */
  	public function handle($request, Closure $next, $guard = null)
    {
        // def get_lang
    	if(session()->exists('lang'))
    	{
      		session(['lang' => 'vi']);
    	}
    	// khong co thi lay gia tri mac dinh la vi
    	I18n.locale = $name = session('lang', 'vi');

  		// def get_cookie
    	if(cookies['uid'])
    	{
      		session(['user' => cookies['uid']]);
    	}
    	
    	//def get_footer
    	//@youtube = store.get_cache("youtube")
    	//unless fragment_exist?("info_page_#{session[:lang]}")
    	if(!Cache::get("info_page_".session('lang')))
    	{
      		$info_footer = Information::limit(4)
    	}  		

  		//def prepare_for_mobile
    	session[:mobile_param] = params[:mobile] if params[:mobile]
    	if(mobile_device?)
    	{
      		if(request.format == :js)
      		{
        		request.format = :mobilejs;
      		}
      		else
      		{
        		request.format = :mobile;
        	}
        }


        return $next($request);
    }
    

  
}
