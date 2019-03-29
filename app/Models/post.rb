class Post < ActiveRecord::Base
  belongs_to :user
  belongs_to :topic,:counter_cache => true
  validates :content,:presence => true
end

# == Schema Information
#
# Table name: posts
#
#  id         :integer         not null, primary key
#  title      :string(255)
#  content    :text
#  user_id    :integer
#  topic_id   :integer
#  created_at :datetime
#  updated_at :datetime
#

