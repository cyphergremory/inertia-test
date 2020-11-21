<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
       'name','date','description'
    ];

    public function scopeFilter(){
        $items = Item::when($query,function($q) use ($query){
            $q->where('name','like',"%$query%");
        })->paginate($request->get('size') ?? 10);
    }
}