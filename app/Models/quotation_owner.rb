class QuotationOwner < ActiveRecord::Base
  
  validates_presence_of :fullname,:email,:phone,:address
  has_many :quotations
  
  def destroy
    Quotation.delete_all(:quotation_owner_id=>self.id)
    super
  end
  
end
