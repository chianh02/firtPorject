class Forum < ActiveRecord::Base
	has_many :topics
	validates :title,:title_en,:uniqueness => true,
	          :if => Proc.new{|a| !a.title_en.blank?}
	 validates :title,
            :presence => true,
            :if => Proc.new {|f| f.title_en.blank?}
	def normalize_friendly_id(text)
		text.to_slug.to_vnlink
	end
	extend FriendlyId
	friendly_id :title, :use => :slugged

	def title_lang(lang)
		case lang
			when "vi" ; return self.title
		else "en" ; return self.title_en
		end
	end

	def description_lang(lang)
		case lang
			when "vi" ; return self.description
		else "en" ; return self.description_en
		end
	end

	def keyword_lang(lang)
		case lang
			when "vi" ; return self.keyword
		else "en" ; return self.keyword_en
		end
	end

	def meta_description_lang(lang)
		case lang
			when "vi" ; return self.meta_description
		else "en" ; return self.meta_description_en
		end
	end
end

