class Photo < ActiveRecord::Base
  dragonfly_accessor :cover_image
  
  after_save :create_file  

  def create_file
    FileUtils::cp(cover_image.thumb("125x125>").path , "#{Rails.root}/public/photo/medium/#{id}.jpg")
    FileUtils::cp(cover_image.path , "#{Rails.root}/public/photo/large/#{id}.jpg")
    FileUtils::chmod(0777, "#{Rails.root}/public/photo/large/#{id}.jpg")
    FileUtils::chmod(0777, "#{Rails.root}/public/photo/medium/#{id}.jpg")
  end
end
