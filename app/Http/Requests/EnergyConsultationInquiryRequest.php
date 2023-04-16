<?php

namespace App\Http\Requests;

use App\Services\EnergyConsultationInquiryService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnergyConsultationInquiryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'max:255'],
            'phone' => ['required', 'max:255'],
            'post_code' => ['required', 'string', 'min:5', 'max:5'],
            'building_type' => ['required', Rule::in(EnergyConsultationInquiryService::BUILDING_TYPES)],
            'units' => ['nullable', 'string', 'min:1'],
            'construction_year' => ['required', 'string', 'min:4', 'max:4'],
            'area' => ['required', 'numeric'],
            'has_roof_insulation' => ['required', Rule::in(EnergyConsultationInquiryService::YES_NO)],
            'windows.material' => ['required', Rule::in(EnergyConsultationInquiryService::WINDOW_MATERIALS)],
            'windows.glazing' => ['required', Rule::in(EnergyConsultationInquiryService::WINDOW_GLAZING)],
            'house_wall.has_insulation' => ['required', Rule::in(EnergyConsultationInquiryService::YES_NO)],
            'house_wall.insulation_material' => ['nullable', Rule::in(EnergyConsultationInquiryService::HOUSE_WALL_INSULATION_MATERIAL)],
            'energy_certificate' => ['nullable', 'file', 'mimes:pdf,jpg,png,zip,7z'],
            'oil_invoices' => ['nullable', 'file', 'mimes:pdf,jpg,png,zip,7z'],
        ];
    }
}
