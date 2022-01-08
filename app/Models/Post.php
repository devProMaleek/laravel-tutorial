<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model
{
    use SoftDeletes;
    protected $dates =['deleted_at'];
    protected $table = 'store';
    use HasFactory;
    protected $fillable = ['Brand', 'Price', 'Shoe_Name', 'Shoe_size'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function photos(){
        return $this->morphMany(Photos::class, 'imageable');
    }

}
