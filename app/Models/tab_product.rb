class TabProduct < ActiveRecord::Base
  
  belongs_to :product
  
  def title_lang(lang)
    case lang
      when "vi" ; return self.title
      else "en" ; return self.title_en
    end
  end
  def content_lang(lang)
    case lang
      when "vi" ; return self.content
      else "en" ; return self.content_en
    end
  end
end

# == Schema Information
#
# Table name: tab_products
#
#  id         :integer         not null, primary key
#  title      :string(255)
#  title_en   :string(255)
#  product_id :integer
#  content    :text
#  content_en :text
#  publish    :boolean         default(TRUE)
#  key        :integer
#  created_at :datetime
#  updated_at :datetime
#

