<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Solucate extends Model
{
  public function normalize_friendly_id($text)
  {
      //$text.to_slug.to_vnlink;
  }
    
  //ext} Fri}lyId
  //fri}ly_id :title, :use => :slugged
  
  public function title_lang($lang)
  {
    switch ($lang) {
      case 'vi':
        return self::title;
        break;
      default:
        return self::title_en;
        break;
    }
  }
  
  public function description_lang($lang)
  {
    switch ($lang) {
      case 'vi':
        return self::description;
        break;
      default:
        return self::description_en;
        break;
    }
  }
  
   public function keyword_lang($lang)
   {
    switch ($lang) {
      case 'vi':
        return self::keyword;
        break;
      default:
        return self::keyword_en;
        break;
    }
  }
  
  public function meta_description_lang($lang)
  {
    switch ($lang) {
      case 'vi':
        return self::meta_description;
        break;
      default:
        return self::meta_description_en;
        break;
    }
  }
  
}
/*
# == Schema Information
#
# Table name: solucates
#
#  id                  :integer         not null, primary key
#  title               :string(255)
#  title_en            :string(255)
#  description         :string(255)
#  description_en      :string(255)
#  created_at          :datetime
#  updated_at          :datetime
#  slug                :string(255)
#  slug_en             :string(255)
#  sort                :integer         public functionault(1)
#  keyword             :string(255)
#  meta_description    :string(255)
#  keyword_en          :string(255)
#  meta_description_en :string(255)
#
*/
