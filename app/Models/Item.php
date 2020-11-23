<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Item extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
       'name','date','description'
    ];

    public function scopeFilter($query,Request $request){
        return $query->when($request->filled('query'),
            fn($q) => $q->where('name','like',"%{$request->get('query')}%")
        )->paginate($request->get('size',10))->toArray();
    }
}