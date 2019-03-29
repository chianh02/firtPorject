<?php

namespace App\Http\Middleware;

use App\Models\Supplier;
use App\Models\Support;
use App\Models\Page;
use App\Models\Information;
use App\Models\Ad;
use App\Models\Subject;
use App\Models\Service;
use App\Models\Solucate;
use App\Models\Basic;
use Illuminate\Support\Facades\View;
use Closure;
use Cache;
//use Illuminate\Http\Request;


class GetMobileOrNot
{ 
    private $category_parents_root1 = null;
    /**
     * The names of the attributes that should not be trimmed.
     * @var array
     */
    public function handle($request, Closure $next, $guard = null)
    { 
      //def get_mobile_or_not
      if(!$this->mobile_device($request))
      {
        $this->get_supply();
        $this->info();
        $this->sub();
        $this->get_category();
        $this->get_header();
        $this->get_notification();
      }else
      {
        $this->get_subject_mobile();
        $marquee = Basic::find(44);
      }
      View::share('category_parents_root1', $this->category_parents_root1);
      return $next($request);
    }
  
    private function get_supply()
    {
      //unless fragment_exist?("supplier")
      if(!Cache::get("supplier"))
      { 
        $suppliers = Supplier::where("image_id > 0")->limit(15);
      }
    }
    private function info()
    {
      //unless fragment_exist?("live-support")
      if(!Cache::get("live-support"))
      {
        //$supports= Support::all();
      }
      $page = Page::find(1);
      $information = Information::find(3);
    }
    private function sub()
    {
      $ad_left = Ad::where("left_ad==true")->first();
      $ad_right = Ad::where("left_ad==false")->first();  
    }
    private function get_category()
    {
      if(!Cache::get("menu-category".session('lang')))
      {
        $this->get_root();
      }

      if(!Cache::get("service_".session('lang')))
      { 
        //$services = Service::orderBy('sort', 'asc');
      }

      if(!Cache::get("solution_".session('lang')))
      {
        $solutions_root1 = Solucate::orderBy('sort', 'asc');
        //$solutions_root2 = Solution::where(:catesolu_id=>@solutions_root1.map{|s| s.id}).order("sort asc");
      }
    }
    private function get_header()
    {
      $logo2 = Basic::find(16);
      $logo3 = Basic::find(17);
      $logo4 = Basic::find(43);
      $ad_top = Basic::find(13);
      $marquee = Basic::find(44);
    }
    private function get_notification()
    {
      //if(current_user())
      //{
      //  $unread = store.get_cache("#{current_user.id.to_s}_notification");
      //}
      //else
      //{
      // $unread = 0;
      //}
    }
    private function get_subject_mobile()
    {
      $subjects_root = Subject::where("parent_id = 0")->orderBy('sort', 'asc');
    }
    private function get_root()
    {
      //$articles = Cache::remember('articles', 22*60, function() {
      //  return Article::all();
      //});
      //return response()->json($articles);
      $this->category_parents_root1 = Subject::where("parent_id = 0")->orderBy('sort', 'asc');
    //select * from subject where parent_id in (select id from subject where parent_id = 0 order sort asc) order sort asc;
      //$category_parents_root2 = Subject::where(:parent_id=>@category_parents_root1.map{|ct| ct.id}).order("sort asc");
      //$category_parents_root3 = Subject::where(:parent_id=>@category_parents_root2.map{|ct| ct.id}).order("sort asc");
    }

    private function mobile_device($request)
    {
      $MOBILE_BROWSERS = array("playbook", "windows phone", "android", "ipod", "iphone", "opera mini", "blackberry", "palm","hiptop","avantgo","plucker", "xiino","blazer","elaine", "windows ce; ppc;", "windows ce; smartphone;","windows ce; iemobile", "up.browser","up.link","mmp","symbian","smartphone", "midp","wap","vodafone","o2","pocket","kindle", "mobile","pda","psp","treo");
      if( session('mobile_param'))
      {
        session('mobile_param',"1");
        return "1";
      }
      else
      {
        //$agent = $request.headers["HTTP_USER_AGENT"].downcase;
        $agent =  mb_strtolower($request->header('User-Agent'));
        foreach ($MOBILE_BROWSERS as  $m)
        { 
          if (strpos($agent,$m))
          {
            return true;
          } 
        }
        //request.user_agent =~ /Mobile|webOS/;
        return preg_match("/Mobile|webOS/", $request->user_agent);
      }
    }
}