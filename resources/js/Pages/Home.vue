<template>
    <main class="flex h-screen">
        <section class="max-w-5xl mr-auto ml-10 my-5 text-center px-12 py-10 hidden md:block">
            <img
                :src="$page.props.image"
                alt="Wunderschönes image von einem Haus"
                class="rounded-2xl"
            >
        </section>
        <section
            class="flex items-center justify-center w-6/12 max-w-5xl mx-auto md:ml-auto md:mr-10 my-5 text-center border-2 px-12 py-10 rounded-2xl shadow-lg">
            <div class="grid grid-rows-2 text-center" v-if="siteCounter < 0">
                <h1 class="text-3xl font-bold mb-7">Jetzt Ihre unverbindliche Energieberatung buchen.</h1>
                <button class="btn btn-wide btn-lg bg-primaer mx-auto" @click="nextField(null)">Jetzt loslegen</button>
            </div>

            <form @submit.prevent="form.post(route('energieberatung.store'))">
                <ul v-show="siteCounter >= 0" class="steps steps-horizontal mb-5">
                    <li :data-content="step" v-for="(step, index) of steps"
                        :class="['step', (step - 1 <= siteCounter) || (step === '...' && index === 1) ? 'step-primary': '']"></li>
                </ul>
                <fieldset v-for="(input, key, index) in inputs" :class="[siteCounter === index ? '' : 'hidden']"
                          class="text-center">
                    <label v-if="input.hasOwnProperty('label')" :for="`${key}${index}`" class="text-lg">
                        <br>
                        {{ input.label }}
                        <br>
                    </label>
                    <template v-if="input.hasOwnProperty('type') && checkRequiredIfCondition(input)">
                        <div class="flex" v-if="input.type === 'radio'">
                            <div class="form-control mx-auto" v-for="(option) in input.options">
                                <label class="label"> {{ option }} </label>
                                <FormInput
                                    :input="input"
                                    v-model="form[key]"
                                    :name="key"
                                    :required="input.is_required !== undefined ? input.is_required : checkRequiredIfCondition(input)"
                                    :value="option"/>
                            </div>
                        </div>

                        <FormInput
                            v-else-if="checkRequiredIfCondition(input)"
                            :input="input"
                            v-model="form[key]"
                            :class="[index !== Object.keys(inputs).length ? 'mb-4' : '']"
                            :required="input.is_required !== undefined ? input.is_required : checkRequiredIfCondition(input)"
                            :name="key"/>

                        <input type="button" class="mt-4 btn btn-wide" :disabled="form[key] === null"
                               :required="input.is_required !== undefined ? input.is_required : checkRequiredIfCondition(input)"
                               @click="nextField(input)" value="Weiter">
                    </template>
                    <template v-else v-for="(field, key2, field_index) in input">
                        <label v-if="field.hasOwnProperty('label') && checkRequiredIfCondition(field)"
                               :for="`${key2}${index}`" class="text-lg">
                            <br>
                            {{ field.label }}
                            <br>
                        </label>
                        <div class="flex" v-if="field.type === 'radio' && checkRequiredIfCondition(field)">
                            <div class="form-control mx-auto" v-for="(option) in field.options"
                                 :class="[field_index !== Object.keys(input).length ? 'mb-4' : '']">
                                <label class="label"> {{ option }} </label>
                                <FormInput
                                    :input="field"
                                    v-model="form[key][key2]"
                                    :name="key+key2"
                                    :required="field.is_required !== undefined ? field.is_required : checkRequiredIfCondition(field)"
                                    :value="option"/>
                            </div>
                        </div>
                        <FormInput
                            v-else-if="checkRequiredIfCondition(field)"
                            :input="field"
                            v-model="form[key][key2]"
                            :class="[field_index !== Object.keys(input).length ? 'mb-4' : '']"
                            :required="field.is_required !== undefined ? field.is_required : checkRequiredIfCondition(field)"
                            :name="key+key2"/>
                    </template>
                    <input v-if="!input.hasOwnProperty('type') && checkRequiredIfCondition(input)" type="button"
                           class="mt-4 btn btn-wide"
                           :disabled="!Object.keys(form[key] ?? {}).every((key2) => ((form[key][key2] !== null) || (inputs[key][key2].is_required !== undefined ? !inputs[key][key2].is_required : !checkRequiredIfCondition(inputs[key][key2]))) === true)"
                           @click="nextField(input)" value="Weiter">
                </fieldset>
                <input v-show="siteCounter === Object.keys(inputs).length" :disabled="form.processing"
                       class="btn btn-primary" type="submit" value="Absenden">
            </form>
        </section>
    </main>
</template>

<script setup>

import {useForm} from "@inertiajs/vue3";
import {reactive, ref} from "vue";
import FormInput from "@/Shared/FormInput.vue";

const name = "Home"

const props = defineProps({
    image: String,
    building_types: Array,
    window_materials: Array,
    window_glazing: Array,
    house_wall_insulation_material: Array
})

const siteCounter = ref(-1);

function nextField(input) {
    siteCounter.value++;

    let keys = Object.keys(inputs);
    if (keys.length - 1 >= siteCounter.value && !checkRequiredIfCondition(inputs[keys[siteCounter.value]])) {
        siteCounter.value++;
    }

    if (4 <= siteCounter.value + 1 && siteCounter.value + 1 <= Object.keys(inputs).length - 1) {
        steps.value[1] = '...';
        steps.value[2] = siteCounter.value + 1
    }

    if (Object.keys(inputs).length - 2 === siteCounter.value) {
        steps.value[3] = siteCounter.value + 2;
    }
}

function checkRequiredIfCondition(obj) {
    if (typeof obj !== 'object' || obj === null) {
        return false;
    }

    if (!obj.hasOwnProperty('required_if')) {
        return true;
    }

    let strings = obj.required_if.split("=");
    let conditions = {'value': strings[0], 'expected': strings[1]}

    let keys = conditions.value.split('.');
    conditions.value = form;
    for (let i = 0; i < keys.length; i++) {
        conditions.value = conditions.value[keys[i]];
    }

    return conditions.value === conditions.expected;
}

const form = useForm({
    'building_type': null,
    'units': null,
    'post_code': null,
    'construction_year': null,
    'area': null,
    'has_roof_insulation': null,
    'windows': {
        'material': null,
        'glazing': null
    },
    'house_wall': {
        'has_insulation': null,
        'insulation_material': null
    },
    'documents': {
        'energy_certificate': null,
        'oil_invoices': null
    },
    'first_name': null,
    'last_name': null,
    'email': null,
    'phone': null,
});

const inputs = reactive({
    'building_type': {
        'label': 'Um was für ein Gebäude handelt es sich?',
        'type': 'radio',
        'options': props.building_types
    },
    'units': {
        'required_if': 'building_type=Mehrfamilienhaus',
        'label': 'Wie viele Wohneinheiten befinden sich darin?',
        'type': 'number',
        'step': 1
    },
    'post_code': {
        'label': 'Wo befindet sich die Immobilie (Postleitzahl)?',
        'placeholder': '12345',
        'type': 'number',
        'step': 1
    },
    'construction_year': {
        'label': 'In welchem Jahr wurde das Gebäude erbaut?',
        'type': 'number'
    },
    'area': {
        'label': 'Wie groß ist die Wohnfläche in Quadratmetern?',
        'type': 'number'
    },
    'has_roof_insulation': {
        'label': 'Ist ihr Dach gedämmt?',
        'type': 'radio',
        'options': [
            'Ja',
            'Nein'
        ]
    },
    'windows': {
        'material': {
            'label': 'Um was für Fenster handelt es sich?',
            'type': 'radio',
            'options': props.window_materials
        },
        'glazing': {
            'label': 'Welche Verglasung weisen die Fenster auf?',
            'type': 'radio',
            'options': props.window_glazing
        }
    },
    'house_wall': {
        'has_insulation': {
            'label': 'Ist die Hauswand gedämmt?',
            'type': 'radio',
            'options': [
                'Ja',
                'Nein'
            ]
        },
        'insulation_material': {
            'required_if': 'house_wall.has_insulation=Ja',
            'label': 'Wie wird Ihre Hauswand gedämmt?',
            'type': 'radio',
            'options': props.house_wall_insulation_material
        },
    },
    'documents': {
        'energy_certificate': {
            'label': 'Laden Sie hier Ihren Energieausweis hoch, falls vorhanden',
            'type': 'file',
            'is_required': false
        },
        'oil_invoices': {
            'label': 'Laden Sie hier Ihren Ölrechnungen hoch, falls vorhanden',
            'type': 'file',
            'is_required': false
        },
    },
    'first_name': {
        'label': 'Wie ist Ihr Vorname?',
        'type': 'text',
    },
    'last_name': {
        'label': 'Wie ist Ihr Nachname?',
        'type': 'text',
    },
    'email': {
        'label': 'Wie ist Ihre E-Mail-Adresse?',
        'type': 'email',

    },
    'phone': {
        'label': 'Wie ist Ihre Telefonnummer?',
        'type': 'text',
    }
});


const steps = ref([
    1, 2, 3, '...', Object.keys(inputs).length + 1
])
</script>
