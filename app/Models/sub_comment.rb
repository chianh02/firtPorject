class SubComment < ActiveRecord::Base
  #apply_simple_captcha
  belongs_to :comment
end
