<?php
namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\str;

trait ModelEventLogger
{
    public static function bootModelEventLogger()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });

        static::created(function ($model) {
            Log::info(class_basename($model) . ' created: ' . self::logIdentifier($model));
        });

        static::updating(function ($model) {
            Log::info(class_basename($model) . ' updating: ' . self::logIdentifier($model));
        });

        static::updated(function ($model) {
            Log::info(class_basename($model) . ' updated: ' . self::logIdentifier($model));
        });

        static::saving(function ($model) {
            Log::warning(class_basename($model) . ' saving: ' . self::logIdentifier($model));
        });

        static::saved(function ($model) {
            Log::warning(class_basename($model) . ' saved: ' . self::logIdentifier($model));
        });

        static::deleting(function ($model) {
            Log::warning(class_basename($model) . ' deleting: ' . $model->id);
        });

        static::deleted(function ($model) {
            Log::warning(class_basename($model) . ' deleted: ' . $model->id);
        });
    }

    protected static function logIdentifier($model)
    {
        return $model->title
            ?? $model->name
            ?? $model->id
            ?? 'N/A';
    }

}