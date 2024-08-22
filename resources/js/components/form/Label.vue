<template>
    <label :for="props.for" class="form-label">
        <slot/>
        <span v-if="props.required" class="text-danger ms-1">*</span>
    </label>
</template>

<script setup>
const props = defineProps({
    for: {
        type: String,
    },
    required: {
        type: Boolean,
    },
});
</script>
