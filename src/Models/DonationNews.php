<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationNews extends Model
{
    protected $table    = 'donation_news';
    public $timestamps  = true;
    protected $fillable = ['title', 'content', 'image'];    
}
