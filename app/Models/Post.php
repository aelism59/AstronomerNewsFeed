<?php

namespace App\Models;

use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    use HasComments;

    protected $fillable = [
        'title', 'contents', 'tag', 'author_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'author_id');
    }
}
