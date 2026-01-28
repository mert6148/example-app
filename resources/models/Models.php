<?php

namespace Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Models extends Model
{
    use SoftDeletes;

    protected $table = 'models';

    protected $fillable = ['name', 'description', 'created_at', 'updated_at'];

    public function relations()
    {
        return $this->hasMany(Relation::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forget('models_cache');
        });

        static::deleted(function ($model) {
            Cache::forget('models_cache');
        });
    }
}
