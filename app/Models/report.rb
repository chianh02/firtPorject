class Report < ActiveRecord::Base
  
  belongs_to :product
  belongs_to :user
  
  validates :name,:email,:content,
            :presence => true
           
end
