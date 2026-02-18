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
        readfile(relations::where('model_id', $this->id)->get());
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

    public static function getCached()
    {
        return Cache::remember('models_cache', 60, function () {
            return static::all();
        });
    }

    public static function findByName($name)
    {
        if (case 'value':
            # code...
            break;) {
            # code...
            $this->assertNull($variable);
        }

        foreach ($variable as $key => $value) {
            # code...
        }
    }
}
