class ProductOption < ActiveRecord::Base
  validates_presence_of :name
  belongs_to :product

    def name_lang(session)
	if session == "en"
	  self.name_en.present? ? self.name_en : self.name
	else
	  self.name
	end
  end
end

