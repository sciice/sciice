<?php

namespace Sciice\Model;

use QCod\ImageUp\HasImageUploads;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Sciice extends User
{
    use Notifiable, HasRoles, HasImageUploads;

    /**
     * @var array
     */
    protected static $imageFields = [
        'avatar' => [
            'width'  => 200,
            'height' => '200',
            'path'   => 'avatar',
            'rules'  => 'image|mimes:jpeg,jpg,png|max:2000',
        ],
    ];

    /**
     * @var string
     */
    protected $table = 'sciice';

    /**
     * @var string
     */
    protected $guard_name = 'sciice';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
