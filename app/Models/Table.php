<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    protected $table = 'table';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'code',
        'capacity',
        'status'
    ];

    public function reservation(): HasMany {
        return $this->hasMany(Reservation::class, 'table_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate UUID jika belum ada
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
