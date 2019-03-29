class OrderExport < ActiveRecord::Base
  has_many :order_export_details
  belongs_to :store
end