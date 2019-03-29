<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
  //has_many :supporters
  //validates :name,:presence => true
  
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
}
