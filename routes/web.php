<?php

use App\Http\Controllers\EnergyConsultationInquiryController;
use App\Models\EnergyConsultationInquiry;
use App\Services\EnergyConsultationInquiryService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::inertia('/', 'Home', [
    'image' => asset('storage/Schnee.png'),
    'building_types' => EnergyConsultationInquiryService::BUILDING_TYPES,
    'window_materials' => EnergyConsultationInquiryService::WINDOW_MATERIALS,
    'window_glazing' => EnergyConsultationInquiryService::WINDOW_GLAZING,
    'house_wall_insulation_material' => EnergyConsultationInquiryService::HOUSE_WALL_INSULATION_MATERIAL,
])->name('home');

Route::post('energieberatung/', [EnergyConsultationInquiryController::class, 'store'])->name('energieberatung.store');

Route::get('terminbuchung/', function () {
    if (session()->has('super_secret')) {
        return Inertia::render('Meeting', ['image' => asset('storage/Schnee.png')]);
    }

    abort(404);
})->name('terminbuchung.create');

Route::inertia('admin/', 'Admin', ['energy_consultation_inquiries' => (static fn () => EnergyConsultationInquiry::all()->each(function ($inquiry) {
    $inquiry->bullet_list = str_replace('\n', '<br><br>', $inquiry->bullet_list);

    return $inquiry->bullet_list;
}))])->name('admin.index');
