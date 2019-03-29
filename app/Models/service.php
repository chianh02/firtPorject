<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  public function normalize_friendly_id(text)
  {
      //text.to_slug.to_vnlink;
  }
  extend FriendlyId
  friendly_id :name, :use => :slugged
  dragonfly_accessor :cover_image
    
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
  end 
}
/*
# == Schema Information
#
# Table name: services
#
#  id                  :integer         not null, primary key
#  name                :string(255)
#  name_en             :string(255)
#  description         :string(255)
#  content             :text
#  content_en          :text
#  image_id            :integer
#  option              :boolean         default(FALSE)
#  created_at          :datetime
#  updated_at          :datetime
#  cover_image_uid     :string(255)
#  cover_image_name    :string(255)
#  description_en      :string(255)
#  date_publish        :datetime
#  slug                :string(255)
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
