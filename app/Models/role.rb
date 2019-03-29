class Role < ActiveRecord::Base
  before_save :downcase_name
  
  def downcase_name
    self.name = self.name.downcase
  end
end
