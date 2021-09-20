<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function blog()
    {
        return $this->hasMany(Blog::class);# Anh muốn bổ sung thêm quan hệ khóa ngoại nữa, vì query ở bên kia e đang sử dụng là find() thì sẽ tự động match
        #cột khóa ngoại user_id của bảng Blog, tương ứng với trường id của bảng Users.
        #nếu trong trường hợp khóa ngoại không đặt là user_id mà đặt một tên khác thì cần truyền thêm một tham số thứ 2.
    }
}
