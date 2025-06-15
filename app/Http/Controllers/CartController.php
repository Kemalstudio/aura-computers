<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart; // <-- ВАЖНО: Используем новый фасад

class CartController extends Controller
{
    /**
     * Показать содержимое корзины
     */
    public function index()
    {
        return response()->json($this->getCartData());
    }

    /**
     * Добавить товар в корзину
     */
    public function add(Request $request, Product $product)
    {
        // Проверка, достаточно ли товара на складе
        if ($product->quantity < $request->input('quantity', 1)) {
            return response()->json(['message' => 'Недостаточно товара на складе'], 422);
        }

        Cart::add(
            $product->id,
            $product->name,
            $request->input('quantity', 1),
            $product->sale_price ?? $product->price,
            ['image' => $product->thumbnail_url, 'slug' => $product->slug]
        )->associate(Product::class); // Связываем с моделью, чтобы легко получать продукт

        return response()->json($this->getCartData());
    }

    /**
     * Обновить количество товара в корзине
     */
    public function update(Request $request, $rowId)
    {
        Cart::update($rowId, $request->input('quantity'));

        return response()->json($this->getCartData());
    }

    /**
     * Удалить товар из корзины
     */
    public function remove($rowId)
    {
        Cart::remove($rowId);

        return response()->json($this->getCartData());
    }
    
    /**
     * Вспомогательная функция для получения данных корзины в нужном формате
     */
    protected function getCartData()
    {
        return [
            'count' => Cart::count(), // Новое: количество товаров
            'total' => Cart::total(2, '.', ''), // Новое: общая сумма
            'items' => Cart::content()->map(function ($item) {
                return [
                    'rowId'    => $item->rowId, // Новое: ID записи в корзине
                    'id'       => $item->id,
                    'name'     => $item->name,
                    'quantity' => $item->qty, // Новое: qty вместо quantity
                    'price'    => $item->price,
                    'image'    => $item->options->image,
                    'slug'     => $item->options->slug,
                ];
            })->values(),
        ];
    }
}