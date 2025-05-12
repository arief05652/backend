<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $table = 'reservation';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id', 
        'tables_id', 
        'status',
        'notes', 
        'capacity', 
        'schedule',
    ];

    public function table(): BelongsTo {
        return $this->belongsTo(Table::class, 'table_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
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


