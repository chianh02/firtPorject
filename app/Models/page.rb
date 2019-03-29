class Page < ActiveRecord::Base
  dragonfly_accessor :cover_image
  #before_save :save_slug 
  belongs_to :information
  def normalize_friendly_id(text)
      text.to_slug.to_vnlink
    end
    
  extend FriendlyId
  friendly_id :name, :use => :slugged
  
  def should_generate_new_friendly_id?
   true
  end
  
  def comments
    Report.where(:category=>1,:product_id=>self.id).order("created_at DESC")
  end
  
  def name_lang(lang)
    case lang
      when "vi" ; return self.name
      else "en" ; return self.name_en
    end
  end
  
  def desc_lang(lang)
    case lang
      when "vi" ; return self.description
      else "en" ; return self.description_en
    end
  end
  def content_lang(lang)
    case lang
      when "vi" ; return self.content
      else "en" ; return self.content_en
    end
  end
  
  def save_slug
    if self.name_en != "" and self.name_en
      self.slug_en = self.name_en.to_vnlink
    else
      self.slug_en = generate_captcha
    end
  end
  
  def slug_lang(lang)
     case lang
      when "vi" ; return self.slug
      else "en" ; return self.slug_en
    end
  end
  
  def keyword_lang(lang)
    case lang
      when "vi" ; return self.keyword
      else "en" ; return self.keyword_en
    end
  end
  
  def meta_description_lang(lang)
    case lang
      when "vi" ; return self.meta_description
      else "en" ; return self.meta_description_en
    end
  end
  
  def generate_captcha(length = 6)
    chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ23456789'
    password = ''
    length.times { |i| password << chars[rand(chars.length)] }
    password
  end
  
   
  
end

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

