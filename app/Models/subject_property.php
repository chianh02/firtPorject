<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectProperty extends Model
{
  
  public $table ='Subject_Properties';

  validates_presence_of :name
  belongs_to :subject
  
  public function name_lang(session)
  {
	if(session == "en")
	{
	  self.name_en.present? ? self.name_en : self.name
	}
	else
	{
	  self.name
	}
  }
  
}

