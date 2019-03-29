class Solution < ActiveRecord::Base
  dragonfly_accessor :cover_image
  def normalize_friendly_id(text)
      text.to_slug.to_vnlink
    end
    
  extend FriendlyId
  friendly_id :title, :use => :slugged
  
  def title_lang(lang)
    case lang
      when "vi" ; return self.title
      else "en" ; return self.title_en
    end
  end
  
  def descripttion_lang(lang)
    case lang
      when "vi" ; return self.descripttion
      else "en" ; return self.descripttion_en
    end
  end
  
  def content_lang(lang)
    case lang
      when "vi" ; return self.content
      else "en" ; return self.content_en
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
  
  
  
end

# == Schema Information
#
# Table name: solutions
#
#  id                  :integer         not null, primary key
#  title               :string(255)
#  descripttion        :string(255)
#  content             :text
#  image_id            :integer
#  option              :boolean         default(FALSE)
#  created_at          :datetime
#  updated_at          :datetime
#  cover_image_uid     :string(255)
#  cover_image_name    :string(255)
#  catesolu_id         :string(255)
#  slug                :string(255)
#  title_en            :string(255)
#  descripttion_en     :string(255)
#  content_en          :string(255)
#  slug_en             :string(255)
#  sort                :integer         default(1)
#  keyword             :string(255)
#  meta_description    :string(255)
#  keyword_en          :string(255)
#  meta_description_en :string(255)
#  hot                 :boolean
#  new                 :boolean
#

