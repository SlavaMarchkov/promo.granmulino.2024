<template>
    <div class="input-group">
        <span class="input-group-text">
            <slot/>
        </span>
        <input
            :placeholder="placeholder"
            :value="modelValue"
            class="form-control"
            @input="handleInput"
        >
        <span class="input-group-text" style="cursor: pointer;"
              @click="handleInput('')"><i
            class="bi bi-x-lg"></i></span>
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: '',
    },
    placeholder: String,
});

const emit = defineEmits([
    'update:modelValue',
]);

const handleInput = (evt) => {
    emit('update:modelValue', evt.target.value);
};
</script>
