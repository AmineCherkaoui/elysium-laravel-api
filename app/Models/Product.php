<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Enums\ProductCategory;

class Product extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nom',
        'slug',
        'fabricant',
        'description',
        'imageUrl',
        'resolutionX',
        'resolutionY',
        'taillePouces',
        'luminositeNits',
        'tauxRafraichissementHz',
        'puissanceWatts',
        'prixLocation',
        'prixVente',
        'category',
    ];

    protected $casts = [
        'taillePouces'           => 'float',
        'puissanceWatts'         => 'float',
        'prixLocation'           => 'float',
        'prixVente'              => 'float',
        'category'               => ProductCategory::class,
        'created_at'             => 'datetime',
        'updated_at'             => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}
