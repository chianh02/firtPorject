class ProductTag < ActiveRecord::Base
  validates_presence_of :name

  def name_lang(session)
	if session == "en"
	  self.name_en.present? ? self.name_en : self.name
	else
	  self.name
	end
  end
end

