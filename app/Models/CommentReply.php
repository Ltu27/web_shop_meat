<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id', 'product_id', 'comment'
    ];

    public function customer() 
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function comment() 
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }
}
