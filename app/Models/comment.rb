class Comment < ActiveRecord::Base
  #apply_simple_captcha
  has_many :sub_comments
end

# == Schema Information
#
# Table name: comments
#
#  id         :integer         not null, primary key
#  name       :string(255)
#  email      :string(255)
#  phone      :string(255)
#  title      :string(255)
#  content    :text
#  created_at :datetime
#  updated_at :datetime
#

