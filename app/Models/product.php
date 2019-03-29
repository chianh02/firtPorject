#encoding: utf-8
class Product < ActiveRecord::Base
  
  RATEPRODUCT = [["Sản phẩm bán chạy",],["Phụ kiện sản phẩm",5]]
  
 # def normalize_friendly_id(text)
 #    text.to_slug.to_vnlink
 # end
#     
  
  dragonfly_accessor :cover_image
  validates_presence_of :name_en
  validates_presence_of :name
  
  has_many :list_images
  #belongs_to :library
  belongs_to :subject
  has_many :listsams
  belongs_to :supplier  
  belongs_to :product_tag
  has_many :tab_products
  has_many :product_options  
  has_many :product_properties
  after_create :product_after_create
  before_create :product_before_create
  before_destroy :product_before_destroy
  before_save :product_before_save

  has_many :bill_prices
  has_many :product_stores
  
  cattr_accessor :search_scopes do
    []
  end

  
  def product_before_create
	#slug = Product.make_slug(name)
  end
  
  def product_after_create
    subject.number_product += 1
    subject.save
  end

  def product_before_save
    if inventory  and inventory < 0
      inventory = 0
    end
  end

  def product_before_destroy
    sams = Listsam.where(product_id: self.id)
    sams.each do |s|
      s.destroy
    end

    sams2 = Listsam.where(id_product: self.id)
    sams2.each do |s2|
      s2.destroy
    end

    subject.number_product -= 1 if subject.number_product > 0
    subject.save
	
	stores = ProductStore.where(product_id: self.id)
	for store in stores
		store.destroy
	end	
  end
  
  def update_subject_id(id, new_id)
    if id.to_i != new_id.to_i
      self.subject.number_product += 1
      self.subject.save
      old_subject = Subject.find(id)      
      old_subject.number_product -= 1
      old_subject.save
    end
  end 
   
  def keyword_lang(lang)
    case lang
      when "vi" ; return self.keyword
      else "en" ; return self.keyword_en
    end
  end
  
  def unit_lang(lang)
    case lang
      when "vi" 
	return self.unit.present? ? self.unit : I18n.t(:unit_product)
      when "en" ; return self.unit_en
      else 
        return self.unit.present? ? self.unit : I18n.t(:unit_product)
    end
  end
  
  def metadesc_lang(lang)
    case lang
      when "vi" ; return self.metadesc
      else "en" ; return self.metadesc_en
    end
  end
  
  def name_lang(lang)
    case lang
      when "vi" ; return self.name
      else "en" ; return self.name_en
    end
  end
  
  def feat_lang(lang)
    case lang
      when "vi" ; return self.feature
      else "en" ; return self.feature_en
    end
  end
  
  def desc_lang(lang)
    case lang
      when "vi" ; return self.description
      else "en" ; return self.description_en
    end
  end
  
  def desc_small_lang(lang)
    case lang
      when "vi" ; return self.desc_small
      else "en" ; return self.desc_small_en
    end
  end
  
  def price_lang(lang)
    case lang
      when "en" ; return self.price_en
      else return self.price
    end
  end
  
  def tran_lang(lang)
    case lang
      when "vi" ; return self.transfer
      else "en" ; return self.transfer_en
    end
  end
  
  def warranty_lang(lang)
    case lang
      when "vi" ; return self.warranty
      else "en" ; return self.warranty_en
    end
  end
  
  def document_lang(lang)
    case lang
      when "vi" ; return self.document
      else "en" ; return self.document_en
    end
  end
  
  def area_lang(lang)
    case lang
      when "vi" ; return self.pay_area_id
      else "en" ; return self.pay_area_id_en
    end
  end
  
  def info_lang(lang)
    case lang
      when "vi" ; return self.info
      else "en" ; return self.info_en
    end
  end
 
  
  NAME = [["Sản Phẩm",1]]
  
  
  
  ActiveRecord::Base.class_eval do
    def sanitize_for_to_param(seo)
      ret = seo.downcase
      #ret = ret.gsub(/[^[:alnum:]]/, '-')  # Replace non alphanumeric characters with hyphen
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
  
   
  def self.update_category(category,old_parent_id,new_parent_id)
    if old_parent_id != new_parent_id
      if category.level == 2
        parent = Subject.find(category.parent_id)
        subject_ids = Subject.where(:parent_id=>category.id).map{|c| c.id}
        for p in Product.where(:subject_id=>subject_ids)
          p.parent_subject_id = new_parent_id
          p.save
        end
      elsif category.level == 3
        for p in Product.where(:subject_id=>category.id)
          p.parent_subject_id = new_parent_id
          p.save
        end
      end
    end
  end


  def self.add_search_scope(name, &block)
    self.singleton_class.send(:define_method, name.to_sym, &block)
    search_scopes << name.to_sym
  end

  def self.simple_scopes
    [
    :ascend_by_created_at,
    :descend_by_created_at,
    :ascend_by_name,
    :descend_by_name
    ]
  end

  def self.add_simple_scopes(scopes)
    scopes.each do |name|
    parts = name.to_s.match(/(.*)_by_(.*)/)
    self.scope(name.to_s, lambda { order("#{Product.quoted_table_name}.#{parts[2]} #{parts[1] == 'ascend' ?  "ASC" : "DESC"}") })
    end
  end

  add_simple_scopes simple_scopes

  add_search_scope :price_between do |low, high|
    where(:price => low..high)
  end

  add_search_scope :price_lte do |price|
    where("price <= ?", price)
  end

  add_search_scope :price_gte do |price|
    where("price >= ?", price)
  end
  
  add_search_scope :inventory do |i|
    where("inventory > ?", 0)
  end
  
  add_search_scope :in_name do |words|
    search([:name_en,:name_slug_search], prepare_words(words))
  end
  
  add_search_scope :in_name_description do |words|
    search([:name,:desc_small], prepare_words(words))
  end

  add_search_scope :in_name_or_description_or_keyword do |words|
    search([:name, :desc_small, :metadesc, :keyword], prepare_words(words))
  end
  
  add_search_scope :auto_search do |words|
	search_auto([:name_slug_search, :name_en], words)
  end

  add_search_scope :in_ids do |*ids|
    where(:id=> ids)
  end
  
  add_search_scope :in_category do |category_id|
    category_ids = Category.where(:parent_id=>category_id).map{|ct| ct.id }
    return where(:category_id=> category_ids)
  end
  
  add_search_scope :represents do |option|
    id = option[:id]
    where().not(:id=>id).where(:option=>2).limit(4)
  end

  private

  def self.prepare_words(words)
    return [''] if words.blank?
    return [words.gsub('"','')] if words.start_with?('"')
    a = words.split(/[,\s]/).map(&:strip)
    a.any? ? a : ['']
  end
  
  def search(field, values)
    where values.map { |value|
      arel_table[field].matches("%#{value}%")
    }.inject(:and)
  end
    
  def self.search(fields, values)
      where fields.map { |field|
        values.map { |value|
          arel_table[field].matches("%#{value}%")
        }.inject(:and)
      }.inject(:or)
  end
  
  def self.search_auto(fields, values)
      where fields.map { |field|        
        arel_table[field].matches("%#{values}%")        
      }.inject(:or)
  end
  
  def self.active
    where('name != ?','')
  end
  
  def self.create_permalink(str)
	ret = make_slug_search(str)	
	ret = ret.gsub(' ', '-') # No more than one of the separator in a row.
	ret = ret.gsub(/-{2,}/, '-')   # Replace 2 - with one
	if p = Product.find_by_slug(ret)
		ret = ret + Time.now.nsec.to_s
	end 
	return ret
  end
  
  def self.make_permalink(str)
	ret = make_slug_search(str)	
	ret = ret.gsub(' ', '-') # No more than one of the separator in a row.
	ret = ret.gsub(/-{2,}/, '-')   # Replace 2 - with one
	return ret
  end
  
  def self.make_slug_search(str)
	ret = str.gsub(/[àáạảãâầấậẩẫăằắặẳẵÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴ]/, 'a')
		ret = ret.gsub(/[ìíịỉĩÌÍỊỈĨ]/, 'i')
		ret = ret.gsub(/[ùúụủũưừứựửữÙÚỤỦŨƯỪỨỰỬỮ]/, 'u')
		ret = ret.gsub(/[èéẹẻẽêềếệểễÈÉẸẺẼÊỀẾỆỂỄ]/, 'e')
		ret = ret.gsub(/[òóọỏõôồốộổỗơờớợởỡÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠ]/, 'o')
		ret = ret.gsub(/[ỳýỵỷỹỲÝỴỶỸ]/, 'y')
		ret = ret.gsub(/[đĐ]/, 'd')
		ret = ret.gsub(/æ/i,'ae')
		ret = ret.gsub(/ç/i, 'c')
		ret = ret.gsub(/ñ/i, 'n')
        ret = ret.gsub(/[^\x00-\x7F]+/, '-') # Remove anything non-ASCII entirely (e.g. diacritics).
	    ret = ret.gsub(/[^\w_ \-]+/i, '-') # Remove unwanted chars.
        ret = ret.gsub(/^\-|\-$/i, '-') # Remove leading/trailing separator.	
        ret = ret.gsub(/-+$/, '')		
		ret = ret.strip
		ret.downcase!
	 return ret
   end
end


