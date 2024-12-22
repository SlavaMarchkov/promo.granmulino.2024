<template>
    <input
        :id="props.id"
        :max="props.max"
        :min="props.min"
        :step="props.step"
        :value="props.modelValue"
        class="form-range"
        type="range"
        @input="handleInput"
    />
</template>

<script setup>
const props = defineProps({
    id: String,
    modelValue: {
        type: [String, Number],
        required: true,
    },
    min: {
        type: Number,
        default: 0,
    },
    max: {
        type: Number,
        default: 5,
    },
    step: {
        type: Number,
        default: 0.5,
    },
});

const emit = defineEmits([
    'update:modelValue',
]);

const handleInput = (event) => {
    emit('update:modelValue', event.target.value);
};
</script>
