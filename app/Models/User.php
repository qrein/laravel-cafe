<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'api_token',
        'password',
    ];
    public function generateToken(){
        $this->update([
            'api_token'=>Str::random(25),
        ]);
        return $this->api_token;
    }

    public function logoutToken() {
        $this->update([
           'api_token'=>null,
        ]);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function find($id)
    {
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function hasRole($roles)
    {
        return in_array($this->role->code, $roles);
    }
}
