<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{	
  protected $table ='suppliers';

  //dragonfly_accessor :cover_image
  //has_many :products
  
  public function normalize_friendly_id($text)
  {
      //$text.to_slug.to_vnlink;
  }
    
  //extend FriendlyId
  //friendly_id :name, :use => :slugged
}