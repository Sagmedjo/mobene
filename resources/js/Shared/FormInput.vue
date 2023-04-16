

<script setup>

defineProps({
    input: {
        required: true
    },
    modelValue: {
        required: true
    },
    name: {
        required: true
    },
    value: {
        required: false,
    },
    required: {
        required: false,
        default: true
    },
});

defineEmits(['update:modelValue'])
</script>

<template>
    <input :type="input.type !== 'number' ? input.type : 'text'" :name="name" :id="name"
           :required="required"
           :value="input.type !== 'radio' && input.type !== 'checkbox' ? modelValue : value"
           :placeholder="input.placeholder"
           :class="[input.type === 'radio' ? 'radio mx-auto checked:bg-red-500' : '',
                    input.type === 'text' || input.type === 'number' || input.type === 'email' ? 'input input-bordered w-full max-w-xs': '',
                    input.type === 'file' ? 'file-input file-input-bordered w-full max-w-xs': '',
                    $attrs.class
           ]"
           @input="$emit('update:modelValue', $event.target.value)"/>
</template>
