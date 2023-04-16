<?php

namespace App\Jobs;

use App\Models\EnergyConsultationInquiry;
use Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AskChatGPT implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public EnergyConsultationInquiry $energyConsultationInquiry
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $wish = 'Gebe deine Antworten in dieser Form an:
        🏠 Wohnfläche: 100 Quadratmeter\n
🌡️ Isolierung: Volldämmung der Fassade, Gedämmtes Dach und gedämmte Zwischendecken\n
🪟 Fenster: dreifach verglaste Holzfenster\n
🔥 Heizungsanlage: Ölheizung\n
🚿 Warmwasser: Ja, mit Wärmepumpe\n
🌍 Klimazone: Gemäßigtes Klima im Südwesten von Deutschland\n\n

Empfohlene Wärmepumpe:\n
🌬️ Luft-Wasser-Wärmepumpe\n
🔥 Heizleistung: mindestens 7 kW\n
💧 Warmwasserbereitung: geeignet\n
💻 Stromverbrauch: optimieren, um genug Strom für die Wärmepumpe zu haben\n';

        $content = "Bitte lege eine Wärmepumpe anhand folgender Parameter aus:
                        Postleitzahl: $this->energyConsultationInquiry->post_code,
                        Gebäudeart: $this->energyConsultationInquiry->building_type,
                        ".($this->energyConsultationInquiry->units ? "Anzahl Wohneinheiten: $this->energyConsultationInquiry->units" : '').",
                        Baujahr: $this->energyConsultationInquiry->construction_year,
                        Wohnfläche: $this->energyConsultationInquiry->area Quadratmeter,
                        Dach gedämmt: ".($this->energyConsultationInquiry->has_roof_insulation ? 'Ja' : 'Nein').",
                        Fenstermaterial: $this->energyConsultationInquiry->window_material,
                        Fensterverglasung: $this->energyConsultationInquiry->window_glazing,
                        Hauswand gedämmt: ".($this->energyConsultationInquiry->house_wall_has_insulation ? 'Ja' : 'Nein').',
                        '.($this->energyConsultationInquiry->house_wall_has_insulation ? "Dämmmaterial der Hauswand: $this->energyConsultationInquiry->house_wall_insulation_material" : '');

        $answer = Http::acceptJson()
            ->withToken(config('services.openai.key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $wish,
                    ],
                    [
                        'role' => 'user',
                        'content' => $content,
                    ],
                ],
            ])->json();

        $this->energyConsultationInquiry->bullet_list = $answer['choices'][0]['message']['content'];
        $this->energyConsultationInquiry->save();
    }
}
