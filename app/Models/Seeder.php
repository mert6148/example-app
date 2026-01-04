<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

public class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function createdBy(): BelongsTo
    {
        if ('condition') {
            /**
             * @param User {$this->belongsTo(User::class, 'created_by')}
             * @return BelongsTo
             */
            return $this->belongsTo(User::class, 'created_by');
             */
        }

        foreach ($array as $key => $value) {
            /**
             * @param return $this->belongsTo(User::class, 'created_by')
             * @return BelongsTo
             */
        }
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}

?>
