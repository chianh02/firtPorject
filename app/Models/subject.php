<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Subject extends Model
{ 

  use Sluggable;

  protected $table ='Subject';
  //protected $fillable =['name','slug'];

  //dragonfly_accessor :cover_image
  public function products()
  {
    return $this->hasMany('App\Product');
  }

  public function subject_properties()
  {
    return $this->hasMany('App\SubjectProperty');
  }

  //after_save :save_sort
  protected static function boot()
  {
    parent::boot();
    // after_save
    self::saved(function(Bug $bug)
    {
      save_sort();
    });
  }
  
  /**
    * Return the sluggable configuration array for this model.
    *
    * @return array
  */
  public function sluggable()
  {
    return [
      'slug' => [
        'source' => 'name'
      ]
    ];
  }
  //extend FriendlyId
  //friendly_id :name, :use => :slugged
  // tam thoi chua conver 2 ham nay
  //public function normalize_friendly_id(text)
  //{
  //   text.to_slug.to_vnlink
  //}
    
  //public function should_generate_new_friendly_id?
  //    return true;
  //}
  
  

  

  public function number_products()
  {
      Product::where('subject_id','=',self::id).count;
  }

  public function name_lang($lang)
  {
    switch ($lang) {
      case 'vi':
        return self::value;
        break;
      case 'en':
        return self::value_en;
        break;
      default:
        return self::value;
        break;
    } 
  }
  
  public function children_show_home()
  {
    Subject::where([ ['parent_id','=',self.id],['show_home','=',true], ]).order("sort asc").limit(6);
  }

  public function new_products()
  {
    $products = [];
    $ids= [];
    $ids = Product::where('parent_subject_id','=',self.id).order("id DESC").limit(3).select("subject_id").distinct;
    foreach($ids as $p){
      $products = Product::where('subject_id','=',p.subject_id).order("id DESC").limit(1).first;
    }
    
  	if ($products.count == 0)
    {
  	  //subject_ids = Subject::where('parent_id','=',self.id).map{|ct| ct.id };  
      //subject_ids << self.id
  		$products = Product::where(subject_id,'in',[subject_ids]).order("id desc").limit(3);
  	}
    return $products;
  }

  public function save_sort()
  {
    if($tip == Subject.last)
    { 
      //self::sort = $tip.id += 1
    }
    else
    {
      //self::sort = 1;
    }
  }
  /*
  ActiveRecord::Base.class_eval do
    def sanitize_for_to_param(seo)
      ret = seo.downcase
      ret = ret.gsub(/[^[:alnum:]]/, '-')  # Replace non alphanumeric characters with hyphen
      ret = ret.gsub(/-{2,}/, '-')         # Replace 2 - with one
      ret = ret.gsub(/-+$/, '')            # Remove - at the end
      return ret
    end
  end
  
  ActiveRecord::Base.class_eval do
    def sanitize_for_to_param_with_vietnamese(seo)
      ret = seo
      ret = ret.gsub(/[àáạảãâầấậẩẫăằắặẳẵÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴ]/, 'a')
      ret = ret.gsub(/[ìíịỉĩÌÍỊỈĨ]/, 'i')
      ret = ret.gsub(/[ùúụủũưừứựửữÙÚỤỦŨƯỪỨỰỬỮ]/, 'u')
      ret = ret.gsub(/[èéẹẻẽêềếệểễÈÉẸẺẼÊỀẾỆỂỄ]/, 'e')
      ret = ret.gsub(/[òóọỏõôồốộổỗơờớợởỡÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠ]/, 'o')
      ret = ret.gsub(/[ỳýỵỷỹỲÝỴỶỸ]/, 'y')
      ret = ret.gsub(/[đĐ]/, 'd')
      ret = sanitize_for_to_param_without_vietnamese(ret)
      return ret
    end
    alias_method_chain :sanitize_for_to_param, :vietnamese
  end*/
}
