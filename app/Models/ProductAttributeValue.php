<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Log;

class ProductAttributeValue extends Pivot 
{
    use HasFactory;

    protected $table = 'product_attribute_values';

    protected $primaryKey = 'id';
    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'product_id',
        'attribute_id',
        'text_value',
        'integer_value',
        'decimal_value',
        'boolean_value',
        'date_value',
        'datetime_value',
    ];

    protected $casts = [
        'boolean_value' => 'boolean',
        'date_value' => 'date',
        'datetime_value' => 'datetime',
        'decimal_value' => 'float',
        'integer_value' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeDefinition(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function getValueAttribute()
    {
        $attributeDef = $this->attributeDefinition;
        if (!$attributeDef && $this->attribute_id) {
            if (!$this->relationLoaded('attributeDefinition')) {
                try {
                    $this->load('attributeDefinition'); 
                } catch (\Exception $e) {
                    Log::error("PAV Getter ID {$this->id}: Failed to load attributeDefinition. Error: " . $e->getMessage());
                    $attributeDef = null; 
                }
            }
            if ($this->relationLoaded('attributeDefinition')) { 
                $attributeDef = $this->getRelation('attributeDefinition');
            }
        }

        if (!$attributeDef) {
            Log::warning("PAV Getter ID {$this->id}: No attributeDefinition. AttrID: {$this->attribute_id}, ProdID: {$this->product_id}");
            return $this->text_value ?? $this->integer_value ?? ($this->decimal_value !== null ? (float)$this->decimal_value : null) ?? ($this->boolean_value !== null ? (bool)$this->boolean_value : null) ?? $this->date_value ?? $this->datetime_value;
        }

        switch (strtolower($attributeDef->type)) {
            case 'text': case 'textarea': case 'select': case 'string': case 'resolution': case 'matrix_type': case 'cpu_type': case 'os_type': case 'color': case 'ram_type': case 'gpu_type': case 'connection_type': case 'interface': case 'sensor_type': case 'backlight': case 'ports_video': case 'aspect_ratio': case 'contrast_ratio': case 'hdr_support': case 'keyboard_type': case 'switch_type': case 'network_support': case 'main_camera_mp': case 'cpu_model': case 'gpu_model': case 'storage_type': case 'cpu_series': case 'gpu_manufacturer': case 'material': case 'dimensions':
            return $this->text_value;
            case 'integer': case 'number': case 'ram_size': case 'ssd_volume': case 'hdd_volume': case 'refresh_rate': case 'cpu_cores': case 'gpu_memory': case 'buttons_count': case 'max_speed_ips': case 'max_acceleration_g': case 'dpi': case 'response_time': case 'brightness': case 'front_camera_mp': case 'battery_capacity': case 'warranty':
            return $this->integer_value;
            case 'decimal': case 'screen_size': case 'float': case 'weight_kg':
            return $this->decimal_value !== null ? (float)$this->decimal_value : null;
            case 'boolean': case 'checkbox': case 'touchscreen': case 'nfc_support':
            return $this->boolean_value !== null ? (bool)$this->boolean_value : null;
            case 'date': return $this->date_value;
            case 'datetime': return $this->datetime_value;
            default: Log::warning("PAV Getter ID {$this->id}: Unhandled type '{$attributeDef->type}'. Fallback. ProdID: {$this->product_id}"); return $this->text_value;
        }
    }

    public function setValueAttribute($value): void
    {
        $attributeDef = $this->attributeDefinition;
        if (!$attributeDef && $this->attribute_id) {
            if (!$this->relationLoaded('attributeDefinition')) {
                try {
                    $this->load('attributeDefinition');
                } catch (\Exception $e) {
                    Log::error("PAV Setter ID {$this->id}: Failed to load attributeDefinition for mutator. Error: " . $e->getMessage());
                    $attributeDef = null;
                }
            }
            if ($this->relationLoaded('attributeDefinition')) {
                $attributeDef = $this->getRelation('attributeDefinition');
            }
        }

        if (!$attributeDef) {
            $this->attributes['text_value'] = $value;
            Log::error("PAV Setter: No attributeDefinition. AttrID: {$this->attribute_id}, ProdID: {$this->product_id}. Stored as text. Value: {$value}");
            return;
        }

        $attributeType = strtolower($attributeDef->type);
        $this->attributes['text_value'] = null; $this->attributes['integer_value'] = null; $this->attributes['decimal_value'] = null; $this->attributes['boolean_value'] = null; $this->attributes['date_value'] = null; $this->attributes['datetime_value'] = null;
        if ($value === null || (is_string($value) && trim($value) === '')) return;

        switch ($attributeType) {
            case 'text': case 'textarea': case 'select': case 'string': case 'resolution': case 'matrix_type': case 'cpu_type': case 'os_type': case 'color': case 'ram_type': case 'gpu_type': case 'connection_type': case 'interface': case 'sensor_type': case 'backlight': case 'ports_video': case 'aspect_ratio': case 'contrast_ratio': case 'hdr_support': case 'keyboard_type': case 'switch_type': case 'network_support': case 'main_camera_mp': case 'cpu_model': case 'gpu_model': case 'storage_type': case 'cpu_series': case 'gpu_manufacturer': case 'material': case 'dimensions':
            $this->attributes['text_value'] = (string) $value; break;
            case 'integer': case 'number': case 'ram_size': case 'ssd_volume': case 'hdd_volume': case 'refresh_rate': case 'cpu_cores': case 'gpu_memory': case 'buttons_count': case 'max_speed_ips': case 'max_acceleration_g': case 'dpi': case 'response_time': case 'brightness': case 'front_camera_mp': case 'battery_capacity': case 'warranty':
            $this->attributes['integer_value'] = is_numeric($value) ? (int)filter_var($value, FILTER_SANITIZE_NUMBER_INT) : null; break;
            case 'decimal': case 'screen_size': case 'float':  case 'weight_kg':
            $this->attributes['decimal_value'] = is_numeric($value) ? (float)filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND) : null; break;
            case 'boolean': case 'checkbox': case 'touchscreen': case 'nfc_support':
            $this->attributes['boolean_value'] = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE); break;
            case 'date': try { $this->attributes['date_value'] = Carbon::parse($value)->toDateString(); } catch (\Exception $e) { $this->attributes['date_value'] = null; Log::warning("PAV Setter: Invalid date '{$value}' for '{$attributeDef->name}'. Err: ".$e->getMessage()); } break;
            case 'datetime': try { $this->attributes['datetime_value'] = Carbon::parse($value)->toDateTimeString(); } catch (\Exception $e) { $this->attributes['datetime_value'] = null; Log::warning("PAV Setter: Invalid datetime '{$value}' for '{$attributeDef->name}'. Err: ".$e->getMessage()); } break;
            default: $this->attributes['text_value'] = (string) $value; Log::warning("PAV Setter ID {$this->id}: Unhandled type '{$attributeType}' for '{$attributeDef->name}'. Stored as text. Value: {$value}");
        }
    }
}
