<template>
    <div class="input-group">
        <span class="input-group-text">
            <slot/>
        </span>
        <Input
            :placeholder="placeholder"
            :type="type"
            :value="modelValue"
            @input="handleInput"

        />
        <span class="input-group-text" style="cursor: pointer;"
              @click="clearInput"><i
            class="bi bi-x-lg"></i></span>
    </div>
</template>

<script setup>
import Input from '@/components/form/Input.vue';

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

const handleInput = (event) => {
    emit('update:modelValue', event.target.value);
};

const clearInput = () => {
    emit('update:modelValue', '');
};
</script>

