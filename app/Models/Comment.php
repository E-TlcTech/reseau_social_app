<?php

namespace App\Models;


use app\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    // nom de la fonction au singulier car 1 seul message en relation
    // cardinalité 1,1
    public function post()
        {
            return $this->belongsTo(Post::class);
        }
    // idem
    public function user()
        {
            return $this->belongsTo(User::class);
        }

}
