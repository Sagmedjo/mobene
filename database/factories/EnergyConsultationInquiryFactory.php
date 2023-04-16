<?php

namespace Database\Factories;

use App\Services\EnergyConsultationInquiryService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EnergyConsultationInquiry>
 */
class EnergyConsultationInquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email' => fake()->email,
            'phone' => fake()->e164PhoneNumber,
            'post_code' => fake()->postcode,
            'bullet_list' => fake()->realText,
            'building_type' => \Arr::random(EnergyConsultationInquiryService::BUILDING_TYPES),
            'units' => fake()->randomNumber(1, true),
            'construction_year' => (int) fake()->year,
            'area' => fake()->randomFloat(min: 1),
            'has_roof_insulation' => fake()->boolean,
            'window_material' => \Arr::random(EnergyConsultationInquiryService::WINDOW_MATERIALS),
            'window_glazing' => \Arr::random(EnergyConsultationInquiryService::WINDOW_GLAZING),
            'house_wall_has_insulation' => fake()->boolean,
            'house_wall_insulation_material' => \Arr::random(EnergyConsultationInquiryService::HOUSE_WALL_INSULATION_MATERIAL),
            'energy_certificate' => fake()->filePath(),
            'oil_invoices' => fake()->filePath(),
        ];
    }
}
