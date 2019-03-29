require 'digest/sha2'
class Admin < ActiveRecord::Base
  has_many :role_admins
  belongs_to :store
  #before_save :hashed_password_user
  attr_accessor :password
  def hashed_password_user
    self.password_encrypted = Admin.encrypt(password) if !self.password.blank?
  end

  def hashed_password_admin(password)
    Admin.encrypt(password) if !password.blank?
  end  

  def password_required?
    self.password_encrypted.blank? || !self.password.blank?
  end
  
  def self.encrypt(string)
    return Digest::SHA256.hexdigest(string)
  end
  
  def self.authenticate(option)
    find_by_email_and_password_encrypted(option[:email].downcase,Admin.encrypt(option[:password]))
  end
  
  def role_names
	ids = role_admins.map{|r| r.role_id}
	names = Role.where(id: ids).map{ |r| r.name }
	return names
  end
  
  def has_role?(role)
    if adm = Role.find_by_name('admin')
	return true if role_admins.where(:role_id=>adm.id).count > 0
    end
    role = Role.find_by_name(role.downcase)    
    role_admins.each do |r|
      if r.role_id == role.id
        return true
      end
    end
    return false
  end
end
