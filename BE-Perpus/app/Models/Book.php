<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory, HasUuids;

    protected $table = "books";
    protected $guarded = ['id'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function list_borrows() {
        return $this->belongsToMany(Borrow::class, 'borrows');
    }
}
