require 'digest/sha2'
class User < ActiveRecord::Base
  has_many :topics
  has_many :posts
  has_many :bill_buys
  has_one :profile
  #attr_protected :hashed_password, :enabled
  attr_accessor :password
  attr_accessor :skip_email_validation, :skip_password_validation
  validates_presence_of :email, unless: :skip_email_validation
  validates_presence_of :fullname
  validates_presence_of :password, unless: :skip_password_validation
  validates_presence_of :password_confirmation, :if => :password_required?
  validates_confirmation_of :password, :if => :password_required?
  validates_uniqueness_of :email, :case_sensitive => false,:on=>:create, unless: :skip_email_validation
 # validates_length_of :email, :within => 8..128
  validates_length_of :password, :within => 5..20, :if => :password_required?
  
  before_destroy :update_database
  
  def update_database
    self.topics.destroy_all
    self.posts.destroy_all
    self.profile.destroy if self.profile
  end  

  def hashed_password_user(password)
    User.encrypt(password) if !password.blank?
  end

  def password_required?
    !self.password.blank?
  end

  def self.encrypt(string)
    return Digest::SHA256.hexdigest(string)
  end

  def self.authenticate(email, password)
	user = where('lower(email) = ?', email.downcase).first 
    if user
    if (user.hashed_password == User.encrypt(password)) and (user.enabled == true)
	return user
    else
       return nil
    end
    else
       return nil
    end
  end

  def generate_captcha(length = 6)
    chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ23456789'
    password = ''
    length.times { |i| password << chars[rand(chars.length)] }
    password
  end
end

