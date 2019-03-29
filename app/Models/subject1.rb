class Subject < ActiveRecord::Base
  dragonfly_accessor :cover_image
  has_many :products
  has_many :subject_properties
  after_save :save_sort
  
  
  def normalize_friendly_id(text)
     text.to_slug.to_vnlink
  end
    
  extend FriendlyId
  friendly_id :name, :use => :slugged
  

  def should_generate_new_friendly_id?
   true
  end

  def number_products
    Product.where(:subject_id=>self.id).count
  end

  def name_lang(lang)
    case lang
      when "vi" ; return self.name
      else "en" ; return self.name_en
    end
  end
  
  def children_show_home
    Subject.where(:parent_id=>self.id,:show_home=>true).order("sort asc").limit(6)
  end

  def new_products
    @products = []
    @ids = Product.where(:parent_subject_id=>self.id).order("id DESC").limit(3).select("subject_id").distinct
	@ids.each do |p|
		@products << Product.where(subject_id: p.subject_id).order("id DESC").limit(1).first
	end
  	if @products.count == 0
  	  subject_ids = Subject.where(:parent_id=>self.id).map{|ct| ct.id }  
      subject_ids << self.id
  		@products = Product.where(:subject_id=>[subject_ids]).order("id desc").limit(3)
  	end
    return @products
  end

  def save_sort
    if tip = Subject.last 
      self.sort = tip.id += 1
    else
      self.sort = 1
    end
  end
  
  ActiveRecord::Base.class_eval do
    def sanitize_for_to_param(seo)
      ret = seo.downcase
      ret = ret.gsub(/[^[:alnum:]]/, '-')  # Replace non alphanumeric characters with hyphen
      ret = ret.gsub(/-{2,}/, '-')         # Replace 2 - with one
      ret = ret.gsub(/-+$/, '')            # Remove - at the end
      return ret
    end
  end
  
  ActiveRecord::Base.class_eval do
    def sanitize_for_to_param_with_vietnamese(seo)
      ret = seo
      ret = ret.gsub(/[àáạảãâầấậẩẫăằắặẳẵÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴ]/, 'a')
      ret = ret.gsub(/[ìíịỉĩÌÍỊỈĨ]/, 'i')
      ret = ret.gsub(/[ùúụủũưừứựửữÙÚỤỦŨƯỪỨỰỬỮ]/, 'u')
      ret = ret.gsub(/[èéẹẻẽêềếệểễÈÉẸẺẼÊỀẾỆỂỄ]/, 'e')
      ret = ret.gsub(/[òóọỏõôồốộổỗơờớợởỡÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠ]/, 'o')
      ret = ret.gsub(/[ỳýỵỷỹỲÝỴỶỸ]/, 'y')
      ret = ret.gsub(/[đĐ]/, 'd')
      ret = sanitize_for_to_param_without_vietnamese(ret)
      return ret
    end
    alias_method_chain :sanitize_for_to_param, :vietnamese
  end
end
