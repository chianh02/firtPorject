class ProductRate < ActiveRecord::Base
  RATE = [["Hàng ưa chuộng",1],["Hàng thông dụng",2],["Hàng khuyến mãi",3],["Sản phẩm bán chạy",4],["Phụ kiện",5],["Sản phẩm ưa chuộng [Product]",6],["Hàng Nổi Bật",7],["Sản phẩm mới [Product]",8]]
  
  ICON = [["NEW",1],["HOT",2],["PROMOTE",3]]
  
  def rate_name
    if self.category == 1
      "Sản phẩm bán chạy"
    end
  end
end
