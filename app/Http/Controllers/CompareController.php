<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CompareController extends Controller
{
    public function index()
    {
        $products = Auth::user()->compares()->with('brand', 'category')->get();
        $comparisonData = [];

        if ($products->isNotEmpty()) {
            // +++ НАЧАЛО НОВОЙ ДИНАМИЧЕСКОЙ ЛОГИКИ +++

            // 1. Создаем "карту" наших атрибутов: `имя_колонки_в_базе` => `Название для пользователя`
            // Чтобы добавить новую характеристику для сравнения, просто добавьте ее в этот массив!
            $attributeMap = [
                // Основные, которые есть всегда
                'price'             => 'Цена',
                'brand'             => 'Бренд', // Особая обработка для связи
                'category'          => 'Категория',
                
                // Характеристики ПК и ноутбуков
                'cpu'               => 'Процессор',
                'ram'               => 'Оперативная память',
                'gpu'               => 'Видеокарта',
                'storage'           => 'Накопитель',
                'screen_diagonal'   => 'Диагональ экрана',
                'screen_resolution' => 'Разрешение экрана',
                'screen_matrix'     => 'Тип матрицы',
                'os'                => 'Операционная система',

                // Дополнительные характеристики (те самые 5-6+ новых)
                'color'             => 'Цвет',
                'weight'            => 'Вес (кг)',
                'dimensions'        => 'Размеры (ДxШxВ)',
                'battery_capacity'  => 'Емкость аккумулятора (мА·ч)',
                'material'          => 'Материал корпуса',
                'guarantee'         => 'Гарантия (мес.)',
                'part_number'       => 'Партийный номер / Модель',
                'description'       => 'Краткое описание',
                
                // Характеристики для ИБП (из вашего примера)
                'voltage'           => 'Напряжение',
                'amperage'          => 'Сила тока',
                'power'             => 'Мощность (Вт)',
                'battery_count'     => 'Количество батарей',
            ];

            // 2. Динамически строим таблицу
            foreach ($attributeMap as $key => $label) {
                $rowValues = [];
                $rowHasData = false; // Флаг, чтобы проверить, есть ли в строке хоть какие-то данные

                foreach ($products as $product) {
                    $value = '—'; // Значение по умолчанию

                    // Обрабатываем связи (как 'brand' и 'category')
                    if ($key === 'brand' || $key === 'category') {
                        if ($product->{$key}) {
                            $value = $product->{$key}->name;
                        }
                    } 
                    // Обрабатываем обычные поля
                    else {
                        if (!empty($product->{$key})) {
                            $value = $product->{$key};
                        }
                    }

                    // Форматируем некоторые значения для красивого вывода
                    if ($key === 'price') {
                        $value = number_format($value, 0, '.', ' ') . ' TMT';
                    }
                    if ($key === 'ram' && is_numeric($value)) {
                        $value .= ' ГБ';
                    }
                    if ($key === 'screen_diagonal' && is_numeric($value)) {
                        $value .= '"';
                    }

                    $rowValues[] = $value;

                    // Если мы нашли хотя бы одно реальное значение (не прочерк), ставим флаг
                    if ($value !== '—') {
                        $rowHasData = true;
                    }
                }

                // Добавляем строку в итоговую таблицу ТОЛЬКО если в ней есть хоть какие-то данные
                if ($rowHasData) {
                    $comparisonData[$label] = $rowValues;
                }
            }
            // +++ КОНЕЦ НОВОЙ ДИНАМИЧЕСКОЙ ЛОГИКИ +++
        }
        
        return view('compare.index', compact('products', 'comparisonData'));
    }

    // Остальные методы (toggle, clear, getCompareDataForJS) остаются без изменений.
    // Я оставлю их здесь для полноты файла.

    public function toggle(Product $product)
    {
        $user = Auth::user();
        $compares = $user->compares();
        $isCompared = $compares->where('product_id', $product->id)->exists();

        if ($isCompared) {
            $compares->detach($product->id);
        } else {
            if ($compares->count() >= 4) {
                return response()->json(['success' => false, 'message' => 'Можно сравнивать не более 4 товаров.'], 422);
            }
            $compares->attach($product->id);
        }

        return response()->json($this->getCompareDataForJS());
    }
    
    public function clear()
    {
        Auth::user()->compares()->detach();
        return response()->json($this->getCompareDataForJS());
    }
    
    public function getCompareDataForJS(): array
    {
        if (!Auth::check()) {
            return ['success' => true, 'count' => 0, 'items' => []];
        }

        $items = Auth::user()->compares()
            ->select('products.id', 'products.name', 'products.thumbnail_url')
            ->get();

        return [
            'success' => true,
            'count' => count($items),
            'items' => $items,
        ];
    }
}