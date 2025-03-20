<template>
    <div class="input-group">
        <span class="input-group-text">
            <slot/>
        </span>
        <TheInput
            :placeholder="placeholder"
            :type="type"
            :value="modelValue"
            @input="handleInput"
        />
        <span
            class="input-group-text input-group-close"
            @click="clearInput"
        ><i class="bi bi-x-lg"></i></span>
    </div>
</template>

<script setup>
import TheInput from '@/components/form/TheInput.vue';

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: '',
    },
    type: {
        type: String,
        default: 'text',
    },
    placeholder: String,
});

const emit = defineEmits([
    'update:modelValue',
]);

const handleInput = (evt) => {
    emit('update:modelValue', evt.target.value);
};

const clearInput = () => {
    emit('update:modelValue', '');
};
</script>

<style scoped>
.input-group-close {
    cursor: pointer;
    transition: background-color .3s;
}

.input-group-close:hover,
.input-group-close:active {
    background-color: #dfdfdf;
}
</style>
