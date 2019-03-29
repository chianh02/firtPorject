<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Basic extends Model
{
  
  /*public function self.save($upload)
  {
    $name =  $upload['value1'].original_filename;
    $directory = "public/images";
    # create the file path
    $path = File.join(directory, name);
    # write the file
    File.open(path, "wb") { |f| f.write(upload['value1'].read) }
  }*/
  
  public function value_lang($lang)
  {
    switch ($lang) {
      case 'vi':
        return self::value;
        break;
      default:
        return self::value_en;
        break;
    }
  }
}
/*
# == Schema Information
#
# Table name: basics
#
#  id         :integer         not null, primary key
#  shell      :string(255)
#  value      :string(255)
#  value_en   :string(255)
#  created_at :datetime
#  updated_at :datetime
#
*/
