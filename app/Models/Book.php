<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'collaborators',
        'name',
        'intro',
    ];

    protected $casts = [
        'collaborators' => 'array'
    ];

    protected $appends = [
        'current_collaborators',
        'role',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function auther(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getCurrentCollaboratorsAttribute(){
        if($this->collaborators != null){
            return User::whereIn('id', $this->collaborators ?? [])->get();
        }
        return [];
    }

    public function getRoleAttribute(){
        if(!Auth::check()){
            return 'guest';
        }
        foreach($this->collaborators as $id)
        {
            if($id == Auth::id()){
                return 'colab';
            }
        }

        if($this->user_id == Auth::id()){
            return 'author';
        }
    }
}
