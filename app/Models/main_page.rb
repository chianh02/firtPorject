class MainPage < ActiveRecord::Base
  dragonfly_accessor :cover_image
  before_save :save_slug 
  belongs_to :information
  def normalize_friendly_id(text)
      text.to_slug.to_vnlink
    end
    
  extend FriendlyId
  friendly_id :name, :use => :slugged
  
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
