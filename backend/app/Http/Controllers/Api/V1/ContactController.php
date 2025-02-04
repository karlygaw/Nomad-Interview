<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\V1\ContactResource;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Получить контакты текущего пользователя с возможностью поиска
    public function index(Request $request)
    {
        $user = $request->user();
        $query = $user->contacts();

        // Добавляем поиск, если передан параметр search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('contactUser', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Возвращаем отфильтрованные контакты
        return ContactResource::collection($query->get());
    }

    // Добавить контакт
    public function store(StoreContactRequest $request)
    {
        $user = $request->user();

        // Проверяем, что пользователь не добавляет сам себя
        if ($user->id === $request->contact_id) {
            return response()->json(['message' => 'You cannot add yourself as a contact'], 400);
        }

        // Проверяем, что контакт уже не добавлен
        $existingContact = Contact::where('user_id', $user->id)
            ->where('contact_id', $request->contact_id)
            ->first();

        if ($existingContact) {
            return response()->json(['message' => 'Contact already exists'], 400);
        }

        // Создаем контакт
        $contact = $user->contacts()->create([
            'contact_id' => $request->contact_id,
            'nickname' => $request->nickname,
        ]);

        return new ContactResource($contact);
    }

    // Показать контакт
    public function show(Request $request, Contact $contact)
    {
        $user = $request->user();
        if ($contact->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return new ContactResource($contact);
    }

    // Обновить псевдоним контакта
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $user = $request->user();
        if ($contact->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $contact->update(['nickname' => $request->nickname]);
        return new ContactResource($contact);
    }

    // Удалить контакт
    public function destroy(Request $request, Contact $contact)
    {
        $user = $request->user();
        if ($contact->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $contact->delete();
        return response()->json(['message' => 'Contact removed']);
    }
}