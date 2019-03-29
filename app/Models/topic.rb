class Topic < ActiveRecord::Base
	belongs_to :forum,:counter_cache => true
	belongs_to :user
	has_many :posts
	validates :title,:body,:forum_id,:presence => true
	def normalize_friendly_id(text)
		text.to_slug.to_vnlink
	end
	extend FriendlyId
	friendly_id :title, :use => :slugged

	def title_lang(lang)
		case lang
			when "vi" ; return title
		else "en" ; return title_en
		end
	end

  def body_lang(lang)
    case lang
      when "vi" ; return body
    else "en" ; return body_en
    end
  end


  def keyword_lang(lang)
    case lang
      when "vi" ; return keyword
    else "en" ; return keyword_en
    end
  end


  def meta_description_lang(lang)
    case lang
      when "vi" ; return meta_description
    else "en" ; return meta_description_en
    end
  end

	def self.search(text)
		if text
			where("title like ? or body like ?","%#{text}%","%#{text}%")
		else
			scoped
		end
	end
end

# == Schema Information
#
# Table name: topics
#
#  id                  :integer         not null, primary key
#  title               :string(255)
#  title_en            :string(255)
#  keyword             :string(255)
#  keyword_en          :string(255)
#  meta_description    :string(255)
#  meta_description_en :string(255)
#  forum_id            :integer
#  user_id             :integer
#  created_at          :datetime
#  updated_at          :datetime
#
