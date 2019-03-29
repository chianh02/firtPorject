class Library < ActiveRecord::Base
  dragonfly_accessor :cover_image
  before_destroy :library_before_destroy

  
  LIST = [["Sản phẩm",1],["Thông Tin",2],["Dịch Vụ",3],["Giải pháp",4],["Người Dùng",5],["Mọi thứ khác",6]]
  after_save :create_file  

  def self.search(title)
    where("cover_image_name like '%#{title}%' ")
  end
  
  def create_file
    FileUtils::cp(cover_image.thumb("125x125>").path , "#{Rails.root}/public/upload/medium/#{id}.jpg")
    FileUtils::cp(cover_image.path , "#{Rails.root}/public/upload/large/#{id}.jpg")
    FileUtils::chmod(0777, "#{Rails.root}/public/upload/large/#{id}.jpg")
    FileUtils::chmod(0777, "#{Rails.root}/public/upload/medium/#{id}.jpg")
  end

  def library_before_destroy
    FileUtils.rm("#{Rails.root}/public/upload/large/#{id}.jpg")
    FileUtils.rm("#{Rails.root}/public/upload/medium/#{id}.jpg")

  end
end
