<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Page extends Model
{

  //use Sluggable;

  protected $table ='pages';

  //dragonfly_accessor :cover_image
  #before_save :save_slug 
  //belongs_to :information
  public function normalize_friendly_id($text)
  {
      text.to_slug.to_vnlink;
  }
    
  //extend FriendlyId
  //friendly_id :name, :use => :slugged
  
  //def should_generate_new_friendly_id?
 //{
   //true
  //end
  
  public function comments()
  {
    Report::where('category=1','product_id=self::id').order("created_at DESC");
  }
  
  public function name_lang($lang)
  {
    switch ($lang) {
      case 'vi':
        return self::name;
        break;
      default:
        return self::name_en;
        break;
    } 
  }
  
  public function desc_lang($lang)
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
  public function content_lang($lang)
  {
    switch ($lang) {
      case 'vi':
        return self::content;
        break;
      default:
        return self::content_en;
        break;
    }
  }
  
  public function save_slug()
  {
    //if self.name_en != "" and self.name_en
    //  self.slug_en = self.name_en.to_vnlink
    //else
    //  self.slug_en = generate_captcha
    //end
    if(self::name_en != "" and self::name_en)
    {
      //self::slug_en = self::name_en.to_vnlink;
    }
    else
    {
      //self::slug_en = generate_captcha;
    }
  }
  
  public function slug_lang($lang)
  {
    switch ($lang) {
      case 'vi':
        return self::slug;
        break;
      default:
        return self::slug_en;
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
  
  public function generate_captcha($length = 6)
  {
    $chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ23456789';
    $password = '';
    //length.times{ { |i| password << chars[rand(chars.length)] }
    //password
  }
}
/*
# == Schema Information
#
# Table name: pages
#
#  id                  :integer         not null, primary key
#  name                :string(255)
#  name_en             :string(255)
#  description         :text
#  description_en      :text
#  content             :text
#  content_en          :text
#  information_id      :integer
#  image_id            :integer
#  option              :boolean         default(FALSE)
#  slug                :string(255)
#  created_at          :datetime
#  updated_at          :datetime
#  cover_image_uid     :string(255)
#  cover_image_name    :string(255)
#  slug_en             :string(255)
#  sort                :integer         default(1)
#  keyword             :string(255)
#  meta_description    :string(255)
#  keyword_en          :string(255)
#  meta_description_en :string(255)
#  hot                 :boolean
#  new                 :boolean
#
*/
