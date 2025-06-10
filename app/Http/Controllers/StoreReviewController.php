<?php

namespace App\Http\Controllers;

use App\Models\StoreReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreReviewController extends Controller
{
    /**
     * Сохраняет новый отзыв о магазине в базу данных.
     */
    public function store(Request $request)
    {
        // 1. Проверка данных (валидация)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'text' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // 2. Если валидация не пройдена, возвращаем ошибку
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 3. Создание и сохранение отзыва в базу данных
        // is_approved = false - отзыв не будет виден на сайте, пока админ его не одобрит.
        // Это очень важный шаг для безопасности!
        StoreReview::create([
            'name' => $request->input('name'),
            'text' => $request->input('text'),
            'rating' => $request->input('rating'),
            'is_approved' => false, // Отправляем на модерацию
        ]);

        // 4. Возвращаем успешный ответ в формате JSON
        return response()->json([
            'message' => 'Ваш отзыв успешно отправлен на модерацию!'
        ]);
    }
}