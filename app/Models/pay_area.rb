class PayArea < ActiveRecord::Base
  
  def money_lang(lang)
    case lang
      when "vi" ; return self.money
      else "en" ; return self.money_en
    end
  end
  
  def city_lang(lang)
    case lang
      when "vi" ; return self.city
      else "en" ; return self.city_en
    end
  end
end

# == Schema Information
#
# Table name: pay_areas
#
#  id         :integer         not null, primary key
#  city       :string(255)
#  money      :decimal(, )
#  money_en   :decimal(, )
#  code       :integer
#  name       :string(255)
#  created_at :datetime
#  updated_at :datetime
#  city_en    :string(255)
#

