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

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'provider_id',
        'avatar',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function adminlte_image()
    {
        // إذا كانت الصورة تحتوي على "googleusercontent" فهذا يعني أنها من Google
        if ($this->avatar && str_contains($this->avatar, 'googleusercontent')) {
            return $this->avatar;
        }

        // إذا لم تكن من Google، استخدم الصورة المخزنة محليًا أو الصورة الافتراضية
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : asset('default-avatar.png');
    }

    public function adminlte_profile_url()
    {
        return route('profile.edit'); // أو أي مسار لصفحة الملف الشخصي
    }

    public function adminlte_desc()
{
    return $this->email; // يمكنك استبدالها بأي وصف آخر للمستخدم
}

}
