<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'username', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'owner_id');
    }

    public function memberProjects()
    {
        return $this->belongsToMany(Project::class, 'project_members');
    }
}