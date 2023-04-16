<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnergyConsultationInquiry extends Model
{
    use HasFactory;

    protected $casts = [
        'has_roof_insulation' => 'boolean',
        'house_wall_has_insulation' => 'boolean',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'post_code',
        'building_type',
        'bullet_list',
        'units',
        'construction_year',
        'area',
        'has_roof_insulation',
        'window_material',
        'window_glazing',
        'house_wall_has_insulation',
        'house_wall_insulation_material',
        'energy_certificate',
        'oil_invoices',
    ];

    public function getUpdatedAtAttribute($date): string
    {
        $date = Carbon::parse($date);

        return $date->format('d.m.Y');
    }

    public function getCreatedAtAttribute($date): string
    {
        $date = Carbon::parse($date);

        return $date->format('d.m.Y');
    }
}
