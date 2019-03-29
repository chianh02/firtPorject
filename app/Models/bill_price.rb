class BillPrice < ActiveRecord::Base
  validates_presence_of :type_bill, :price
  belongs_to :product

  after_save :update_product_price

  def update_product_price
    price = BillPrice.where(:product_id=>self.product_id).order("id asc").first

    nproduct = self.product

    nproduct.price = price.price.to_i
    nproduct.save

  end

  def price_lang(lang)
    case lang
      when "vi" ; return self.price
      else "en" ; return self.price_en
    end
  end
end

# == Schema Information
#
# Table name: bill_prices
#
#  id         :integer         not null, primary key
#  type_bill  :string(255)
#  price      :string(255)
#  price_en   :string(255)
#  product_id :integer
#  created_at :datetime
#  updated_at :datetime
#

