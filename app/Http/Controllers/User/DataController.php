<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataController extends Controller {
    /**
     * Показывает форму для редактирования данных
     */
    public function edit(User $user) {
        $timezones = User::TIMEZONES;
        return view('user.data', compact('user', 'timezones'));
    }

    /**
     * Обновляет данные пользователя в базе данных
     */
    public function update(Request $request, User $user) {
        /*
         * Проверяем данные формы
         */
        $request->validate([
            'name' => 'required|max:255',
            'timezone' => 'nullable|max:255'
        ]);
        /*
         * Обновляем пользователя
         */
        $user->update($request->only(['name', 'timezone']));
        /*
         * Возвращаемся на главную
         */
        return redirect()
            ->route('user.index')
            ->with('success', 'Данные успешно обновлены');
    }
}
