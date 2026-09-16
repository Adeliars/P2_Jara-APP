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

    // Relasi User ke Project
    public function projects()
    {
        // Menghubungkan ke Project melalui tabel pivot 'project_user'
        // dan mengambil data tambahan 'role' dari tabel pivot tersebut
        return $this->belongsToMany(Project::class, 'project_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function memberProjects()
    {
        return $this->belongsToMany(Project::class, 'project_user');
    }
}