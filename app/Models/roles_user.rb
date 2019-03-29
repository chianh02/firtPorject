class RolesUser < ActiveRecord::Base
  belongs_to :admin
  ROLESUSER = [["Admin","1"],["Moderator",'2'],["Pager","3"],["Producter","4"]]
end
