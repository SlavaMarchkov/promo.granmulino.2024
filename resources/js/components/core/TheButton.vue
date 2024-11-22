<template>
    <button
        :type="props.type"
        :disabled="props.disabled"
        :loading="props.loading"
        :class="props.buttonClass"
    >
        <span v-if="props.loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <slot v-else/>
    </button>
</template>

<script setup>
const props = defineProps({
    loading: {
        type: Boolean,
        required: false,
    },
    disabled: Boolean,
    buttonClass: {
        type: String,
        default: 'btn',
    },
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<style scoped>
.btn.disabled, .btn:disabled {
    pointer-events: initial;
}

.btn-cursor-not-allowed {
    cursor: not-allowed;
}
</style>
