class ProductStore < ActiveRecord::Base
    belongs_to :product
    belongs_to :store
    before_save :product_store_before_save

  def product_store_before_save
    if inventory < 0
      inventory = 0
    end
  end
end
