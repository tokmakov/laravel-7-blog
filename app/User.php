<?php

namespace App;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable {

    use Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at', 'timezone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const TIMEZONES = [
        'Europe/Kaliningrad' => 'Калининград, Россия (+02:00)',
        'Europe/Moscow' => 'Москва, Россия (+03:00)',
        'Europe/Astrakhan' => 'Астрахань, Россия (+04:00)',
        'Asia/Yekaterinburg' => 'Екатеринбург, Россия (+05:00)',
        'Asia/Omsk' => 'Омск, Россия (+06:00)',
        'Asia/Novosibirsk' => 'Новосибирск, Россия (+07:00)',
        'Asia/Irkutsk' => 'Иркутск, Россия (+08:00)',
        'Asia/Chita' => 'Чита, Россия (+09:00)',
        'Asia/Vladivostok' => 'Владивосток, Россия (+10:00)',
        'Asia/Magadan' => 'Магадан, Россия (+11:00)',
        'Asia/Kamchatka' => 'Петропавловск-Камчатский, Россия (+12:00)'
    ];

    /**
     * Связь модели Auth с моделью Post, позволяет получить все
     * посты пользователя
     */
    public function posts() {
        return $this->hasMany(Post::class);
    }

    /**
     * Связь модели Auth с моделью Comment, позволяет получить все
     * комментарии пользователя
     */
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public static function getRandomEditor() {
        $users = self::inRandomOrder()->get();
        foreach ($users as $user) {
            if ($user->hasPermAnyWay('publish-post')) {
                return $user;
            }
        }
    }

    /**
     * Преобразует дату и время регистрации пользователя из UTC в Europe/Moscow
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getCreatedAtAttribute($value) {
        $timezone = 'Europe/Moscow';
        if ($this->timezone) {
            $timezone = $this->timezone;
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)
            ->timezone($timezone)->format('d.m.Y H:i');
    }

    /**
     * Преобразует дату и время обновления пользователя из UTC в Europe/Moscow
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getUpdatedAtAttribute($value) {
        $timezone = 'Europe/Moscow';
        if ($this->timezone) {
            $timezone = $this->timezone;
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)
            ->timezone($timezone)->format('d.m.Y H:i');
    }
}
