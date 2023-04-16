<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnergyConsultationInquiryRequest;
use App\Jobs\AskChatGPT;
use App\Models\EnergyConsultationInquiry;
use Illuminate\Http\Request;

class EnergyConsultationInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EnergyConsultationInquiryRequest $request)
    {
        $data = $request->validated();
        $houseWallHasInsulation = $data['house_wall']['has_insulation'] === 'Ja';
        $energyConsultationInquiry = EnergyConsultationInquiry::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'post_code' => $data['post_code'],
            'building_type' => $data['building_type'],
            'units' => $data['units'],
            'construction_year' => $data['construction_year'],
            'area' => $data['area'],
            'has_roof_insulation' => $data['has_roof_insulation'] === 'Ja',
            'window_material' => $data['windows']['material'],
            'window_glazing' => $data['windows']['glazing'],
            'house_wall_has_insulation' => $houseWallHasInsulation,
            'house_wall_insulation_material' => $houseWallHasInsulation ? $data['house_wall']['insulation_material'] ?? null : null,
        ]);

        if ($request->file('documents.energy_certificate')) {
            $energyConsultationInquiry->energy_certificate = $request->file('documents.energy_certificate')->store('energy_certificates');
        }

        if ($request->file('documents.oil_invoices')) {
            $energyConsultationInquiry->oil_invoices = $request->file('documents.oil_invoices')->store('oil_invoices');
        }

        $energyConsultationInquiry->save();
        AskChatGPT::dispatchAfterResponse($energyConsultationInquiry);

        session()->flash('super_secret', \Str::random(60));

        return redirect()->route('terminbuchung.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
