class Uploadfile < ActiveRecord::Base
  
  def self.uploadfile(upload)
    name =  upload['url'].original_filename
    directory = "public/upload"
    # create the file path
    path = File.join(directory, name)
    # write the file
    File.open(path, "wb") { |f| f.write(upload['url'].read) }
  end
  
  
end

# == Schema Information
#
# Table name: uploadfiles
#
#  id         :integer         not null, primary key
#  category   :integer
#  subject    :integer
#  url        :string(255)
#  name       :string(255)
#  created_at :datetime
#  updated_at :datetime
#

