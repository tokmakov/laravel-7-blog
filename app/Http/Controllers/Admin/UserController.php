<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('perm:manage-users')->only('index');
        $this->middleware('perm:edit-user')->only(['edit', 'update']);
    }

    /**
     * Показывает список всех пользователей
     */
    public function index() {
        $users = User::paginate(5);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Показывает права и роли пользователя
     */
    public function show(User $user) {
        $roles = Role::all();
        $perms = Permission::all();
        return view(
            'admin.user.show',
            compact('user', 'roles', 'perms')
        );
    }

    public function assignRole(User $user, Role $role) {
        if ( ! auth()->user()->hasPermAnyWay('assign-role')) {
            return redirect()
                ->route('admin.user.show', ['user' => $user->id])
                ->withErrors('Нет прав на выполнение этого действия');
        }
        $user->assignRoles($role->slug);
        return redirect()
            ->route('admin.user.show', ['user' => $user->id])
            ->with('success', 'Данные пользователя успешно обновлены');
    }

    public function assignPerm(User $user, Permission $perm) {
        if ( ! auth()->user()->hasPermAnyWay('assign-permission')) {
            return redirect()
                ->route('admin.user.show', ['user' => $user->id])
                ->withErrors('Нет прав на выполнение этого действия');
        }
        $user->assignPermissions($perm->slug);
        return redirect()
            ->route('admin.user.show', ['user' => $user->id])
            ->with('success', 'Данные пользователя успешно обновлены');
    }

    public function unassignRole(User $user, Role $role) {
        if ( ! auth()->user()->hasPermAnyWay('assign-role')) {
            return redirect()
                ->route('admin.user.show', ['user' => $user->id])
                ->withErrors('Нет прав на выполнение этого действия');
        }
        $user->unassignRoles($role->slug);
        return redirect()
            ->route('admin.user.show', ['user' => $user->id])
            ->with('success', 'Данные пользователя успешно обновлены');
    }

    public function unassignPerm(User $user, Permission $perm) {
        if ( ! auth()->user()->hasPermAnyWay('assign-permission')) {
            return redirect()
                ->route('admin.user.show', ['user' => $user->id])
                ->withErrors('Нет прав на выполнение этого действия');
        }
        $user->unassignPermissions($perm->slug);
        return redirect()
            ->route('admin.user.show', ['user' => $user->id])
            ->with('success', 'Данные пользователя успешно обновлены');
    }

    /**
     * Показывает форму для редактирования пользователя
     */
    public function edit(User $user) {
        $allroles = Role::all();
        $allperms = Permission::all();
        return view(
            'admin.user.edit',
            compact('user', 'allperms', 'allroles')
        );
    }

    /**
     * Обновляет данные пользователя в базе данных
     */
    public function update(Request $request, User $user) {
        /*
         * Проверяем данные формы
         */
        $this->validator($request->all(), $user->id)->validate();
        /*
         * Обновляем пользователя
         */
        if ($request->change_password) { // если надо изменить пароль
            $request->merge(['password' => Hash::make($request->password)]);
            $user->update($request->all());
        } else {
            $user->update($request->except('password'));
        }
        /*
         * Назначаем роли и права
         */
        if (auth()->user()->hasPermAnyWay('assign-role')) {
            $user->roles()->sync($request->roles);
        }
        if (auth()->user()->hasPermAnyWay('assign-permission')) {
            $user->permissions()->sync($request->perms);
        }
        /*
         * Возвращаемся к списку
         */
        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Данные пользователя успешно обновлены');
    }

    /**
     * Возвращает объект валидатора с нужными нам правилами
     */
    private function validator(array $data, int $id) {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // проверка на уникальность email, исключая
                // этого пользователя по идентифкатору
                'unique:users,email,'.$id.',id',
            ],
        ];
        if (isset($data['change_password'])) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }
        return Validator::make($data, $rules);
    }
}

