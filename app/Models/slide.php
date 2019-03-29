<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table ='slides';
    //image_accessor :cover_image

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
/**
# == Schema Information
#
# Table name: slides
#
#  id         :integer         not null, primary key
#  value      :string(255)
#  image_id   :integer
#  created_at :datetime
#  updated_at :datetime
#  value_en   :string(255)
#
*/