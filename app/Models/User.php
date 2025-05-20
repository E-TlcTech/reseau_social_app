<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // nom au pluriel car un user peut poster plusieurs posts
    // cardinalité 0,n
    public function posts()
        {
            return $this->hasMany(Post::class);
        }
    // nom au pluriel car un user peut poster plusieurs commentaires
    // cardinalité 0,n
    
    public function comments()
        {
            return $this->hasMany(Comment::class);
        }
    // nom de la fonction au singulier car 1 seul rôle en relation
    // cardinalité 1,1
       
    public function role()
        {
            return $this->belongsTo(Role::class);
        }
    //charger automatiquement le rôle de l'utilisateur
       
    protected $with = ['role'];
        
       
    public function isAdmin()
       {
    // Vérifie si l'utilisateur a le rôle d'administrateur
        
            return $this->role_id == 2;
        }
    
 

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'pseudo',
        'image',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
