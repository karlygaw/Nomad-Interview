<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken("Token of user: {$user->name}")->plainTextToken
        ], 201);
    }

    public function login(LoginUserRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Wrong email or password'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        // Удаляем старые токены, чтобы выдавать новый
        $user->tokens()->delete();

        return response()->json([
            'user' => $user,
            'token' => $user->createToken("Token of user: {$user->name}")->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json([
            'message' => 'Token removed'
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        // Валидация входных данных
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $user->id,
            'address' => 'nullable|string|max:255',
        ]);

        // Обновление данных
        $user->update($validated);

        return response()->json([
            'user' => $user,
        ]);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        // Удаление всех контактов
        $user->contacts()->delete();
        $user->addedBy()->delete();

        // Удаление токенов
        $user->tokens()->delete();

        // Удаление самого пользователя
        $user->delete();

        return response()->json([
            'message' => 'User and all associated contacts deleted successfully',
        ]);
    }

    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    public function index(Request $request)
    {
        $currentUserId = $request->user()->id;

        // Получаем все contact_id, где user_id совпадает с текущим пользователем
        $excludedUserIds = DB::table('contacts')
            ->where('user_id', $currentUserId)
            ->pluck('contact_id')
            ->toArray();

        // Исключаем найденных пользователей + самого текущего пользователя
        $excludedUserIds[] = $currentUserId;

        // Получаем всех пользователей, кроме исключённых
        $users = User::whereNotIn('id', $excludedUserIds)->get();

        return response()->json([
            'users' => $users
        ]);
    }

    // Новый метод для поиска пользователей
    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string|min:1', // Параметр поиска обязателен
        ]);

        $search = $request->input('search');
        $currentUserId = $request->user()->id; // Исключаем текущего пользователя из поиска

        $users = User::where('id', '!=', $currentUserId) // Исключаем текущего пользователя
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->get();

        return response()->json([
            'users' => $users
        ]);
    }
}
