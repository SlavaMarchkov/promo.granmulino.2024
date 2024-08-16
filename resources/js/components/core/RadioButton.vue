<template>
    <div class="input-group">
        <div class="input-group-text">
            <input
                :id="props.id"
                :name="props.name"
                :value="props.value"
                :checked="isChecked"
                class="form-check-input mt-0"
                type="radio"
                @change="changeSelect"
            >
        </div>
        <label
            :for="props.id"
            class="form-control text-start"
        >
            <slot/>
        </label>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    id: String,
    name: String,
    modelValue: {
        type: String,
        default: '',
    },
    value: {
        type: String,
        default: '',
    },
});

const emit = defineEmits([
    'update:modelValue',
]);

const changeSelect = () => {
  emit('update:modelValue', props.value);
};

const isChecked = computed(() => {
    return props.modelValue === props.value;
});
</script>
