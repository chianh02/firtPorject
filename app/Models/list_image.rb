class ListImage < ActiveRecord::Base
  dragonfly_accessor :cover_image
  
  belongs_to :list_image
end

# == Schema Information
#
# Table name: list_images
#
#  id               :integer         not null, primary key
#  product_id       :integer
#  image_id         :integer
#  created_at       :datetime
#  updated_at       :datetime
#  cover_image_uid  :string(255)
#  cover_image_name :string(255)
#

