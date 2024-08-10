<template>
    <div class="input-group">
        <div class="input-group-text">
            <input
                :id="props.id"
                :checked="modelValue"
                class="form-check-input mt-0"
                type="checkbox"
                @change="$emit('update:modelValue', !modelValue)"
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
const props = defineProps({
    id: String,
    modelValue: {
        type: Boolean,
        default: false,
    },
});
</script>
