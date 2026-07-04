<?php

namespace App\Models;

use Database\Factories\PlanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'subtitle',
        'description',
        'price_one_time',
        'price_monthly',
        'price_yearly',
    ];

    protected function casts(): array
    {
        return [
            'price_one_time' => 'integer',
            'price_monthly' => 'integer',
            'price_yearly' => 'integer',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_plan');
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}

