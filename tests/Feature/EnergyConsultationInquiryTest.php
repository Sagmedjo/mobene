<?php

use App\Models\EnergyConsultationInquiry;
use App\Services\EnergyConsultationInquiryService;

it('has home page', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
});

it('can send store request', function () {
    $gptMessage = 'Hallo, liebes Mesh-Team. Wir haben das beste Projekt ;)';
    Http::fake([
        'https://api.openai.com/v1/chat/completions' => Http::response(
            ['choices' => [['message' => ['content' => $gptMessage]]]]
        ),
    ]);

    $buildingType = \Arr::random(EnergyConsultationInquiryService::BUILDING_TYPES);
    $houseWallHasInsulation = \Arr::random(EnergyConsultationInquiryService::YES_NO);
    $data = [
        'first_name' => fake()->firstName,
        'last_name' => fake()->lastName,
        'email' => fake()->email,
        'phone' => fake()->e164PhoneNumber,
        'post_code' => (string) fake()->randomNumber(5, true),
        'building_type' => $buildingType,
        'units' => $buildingType === 'Mehrfamilienhaus' ? (string) fake()->randomNumber(1, true) : null,
        'construction_year' => fake()->year,
        'area' => round(fake()->randomFloat(nbMaxDecimals: 10, min: 1), 2),
        'has_roof_insulation' => \Arr::random(EnergyConsultationInquiryService::YES_NO),
        'windows' => [
            'material' => \Arr::random(EnergyConsultationInquiryService::WINDOW_MATERIALS),
            'glazing' => \Arr::random(EnergyConsultationInquiryService::WINDOW_GLAZING),
        ],
        'house_wall' => [
            'has_insulation' => $houseWallHasInsulation,
            'insulation_material' => $houseWallHasInsulation === 'Ja' ? \Arr::random(EnergyConsultationInquiryService::HOUSE_WALL_INSULATION_MATERIAL) : null,
        ],
    ];

    $this->post(route('energieberatung.store'), $data)
        ->assertRedirect(route('terminbuchung.create'));

    expect(EnergyConsultationInquiry::find(1))
        ->first_name->toBe($data['first_name'])
        ->last_name->toBe($data['last_name'])
        ->email->toBe($data['email'])
        ->phone->toBe($data['phone'])
        ->post_code->toBe((int) $data['post_code'])
        ->building_type->toBe($data['building_type'])
        ->units->toBe($data['units'] ? (int) $data['units'] : null)
        ->construction_year->toBe((int) $data['construction_year'])
        ->area->toBe($data['area'])
        ->has_roof_insulation->toBe($data['has_roof_insulation'] === 'Ja')
        ->window_material->toBe($data['windows']['material'])
        ->window_glazing->toBe($data['windows']['glazing'])
        ->house_wall_has_insulation->toBe($data['house_wall']['has_insulation'] === 'Ja')
        ->house_wall_insulation_material->toBe($data['house_wall']['insulation_material'])
        ->bullet_list->toBe($gptMessage);

    $this->followingRedirects()
        ->post(route('energieberatung.store'), $data)
        ->assertSuccessful();
});

it('can only access terminbuchung page after sending energy consultation inquiry', function () {
    $this->get(route('terminbuchung.create'))->assertNotFound();
});
