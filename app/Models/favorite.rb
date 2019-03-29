class Favorite < ActiveRecord::Base
	validates_presence_of :user_id, :product_id
	
  def save
    f = Favorite.find_by_product_id_and_user_id(self.product_id,self.user_id) 
    if f
      return true
    else
      super
    end
  end
end