<template>
    <input
        :id="field.id"
        :value="props.modelValue"
        @input="handleInput"
        :required="field.required"
        :class="[
			'form-control',
			field.invalid ? 'is-invalid' : '',
			field.valid ? 'is-valid' : '',
		]"
    >
</template>

<script setup>
import { inject } from 'vue';

const props = defineProps({
    id: String,
    modelValue: {
        type: [String, Number],
        default: '',
    },
    required: Boolean,
    invalid: String,
    valid: Boolean,
});

const emit = defineEmits([
    'update:modelValue',
]);

const handleInput = (event) => {
    emit('update:modelValue', event.target.value);
};

const field = inject('field', props);
</script>
