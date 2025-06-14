<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Log;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'text'        => 'required|string|min:10',
            'rating'      => 'required|integer|min:1|max:5',
            'product_id'  => 'required|exists:products,id',
        ], [
            'name.required'        => 'Поле "Ваше имя" обязательно для заполнения.',
            'text.required'        => 'Пожалуйста, напишите текст отзыва.',
            'text.min'             => 'Текст отзыва должен содержать не менее 10 символов.',
            'rating.required'      => 'Пожалуйста, поставьте оценку от 1 до 5 звезд.',
            'product_id.exists'    => 'Выбранный товар не найден. Пожалуйста, выберите из подсказок.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $review = new ProductReview();
            $review->name = $request->input('name');
            $review->text = $request->input('text');
            $review->rating = $request->input('rating');
            $review->product_id = $request->input('product_id');

            // === КЛЮЧЕВАЯ СТРОКА ===
            // Всегда сохраняем новый отзыв как НЕОДОБРЕННЫЙ.
            $review->is_approved = false;

            $review->save();

            // Загружаем данные о товаре для ответного JSON
            $review->load('product');
        } catch (\Exception $e) {
            Log::error('КРИТИЧЕСКАЯ ОШИБКА ПРИ СОЗДАНИИ ОТЗЫВА: ' . $e->getMessage());
            return response()->json([
                'message' => 'Не удалось сохранить отзыв из-за внутренней ошибки сервера.'
            ], 500);
        }

        // Возвращаем корректное сообщение пользователю
        return response()->json([
            'message' => 'Спасибо! Ваш отзыв отправлен на модерацию.',
            'review'  => $review // Можно оставить, если понадобится в будущем
        ], 201);
    }
}
