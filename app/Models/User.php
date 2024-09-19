<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $primaryKey = 'sid';

    protected $guarded = [
        'sid',
    ];

    protected $dates = [
        'password_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [

    ];

    public function setByData($data)
    {
        if(empty($this->sid)) {
            $this->uid = $data['uid'];
            $this->name_kr = $data['name_kr'];
            $this->password = Hash::make($data['password']);
            $this->password_at = now();
        }

        $this->email = $data['email'];
        $this->license_number = $data['license_number'];
    }

}
