<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class VerifyEmailController extends Controller {

    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Сообщение сразу после регистрации
     */
    public function message() {
        return view('auth.verify-message');
    }

    /**
     * Активация аккаунта после перехода по ссылке
     */
    public function verify($token, $id) {
        // удаляем пользователей, которые не подтвердили
        $expire = Carbon::now()->subMinute(60);
        User::whereNull('email_verified_at')->where('created_at', '<', $expire)->delete();
        // пробуем найти пользователя по идентификатору
        $user = User::find($id);
        $condition = $user && md5($user->email . $user->name) === $token;
        if (!$condition) {
            return redirect()
                ->route('auth.register')
                ->withErrors('Ссылка для проверки адреса почты устарела');
        }
        // все проверки пройдены, активируем аккаунт
        $user->update(['email_verified_at' => Carbon::now()]);
        // назначаем роль для нового пользователя
        $user->assignRoles('user');
        return redirect()
            ->route('auth.login')
            ->with('success', 'Вы успешно подтвердили свой адрес почты');
    }
}
