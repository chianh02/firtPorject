class BillBuy < ActiveRecord::Base
  LANG = [["Việt Nam",1],["English",2]]
  
  
  validates :address,:name,:email,:phone,
            :presence => true
  has_many :list_bills, :dependent => :destroy
  belongs_to :admin
  belongs_to :store
  belongs_to :user
  
  after_create :bill_buy_after_create
  
  def bill_buy_after_create
	if user 
         user.count_buy += 1
	  user.save(validate: false)
       end
  end
  
  def total
    total = 0
    for l in list_bills
      if l.price and l.quantity
      total += l.price * l.quantity
      end
    end
    return total
  end
end
