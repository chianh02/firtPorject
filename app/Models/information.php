<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
  //has_many :pages
  
  public function normalize_friendly_id($text)
  {
      //text.to_slug.to_vnlink;
  }
    
  //extend FriendlyId
  //friendly_id :name, :use => :slugged
  
  
  //$INFORAMTION = array(["Thong Tin Cong Ty",1],["Dich Vu Ban Hang","2"],["Quy Dinh Khach Hang","3"],["Dich Vu Hau Mai",4],["Tin Cong Nghe",5],["Nha Cung Cap",6]);
  
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
  
  public function save_slug()
  {
    if(self::name_en != "" and self::name_en)
    {
      //self::slug_en = self::name_en->to_vnlink;
    }
    else{
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
    $hars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ23456789';
    $password = '';
    //$length.times { |i| password << chars[rand(chars.length)] }
    //password
  }

}


