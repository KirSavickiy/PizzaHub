<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function deleteWithCheck(): bool
    {
        if ($this->products()->exists()) {
            return false;
        }

        $this->delete();
        return true;
    }
}
