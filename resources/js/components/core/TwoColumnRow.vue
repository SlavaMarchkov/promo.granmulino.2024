<template>
    <div class="row mb-1">
        <div class="col-6 text-accent"><span v-html="props.title"></span></div>
        <div class="col-6 fw-bold">
            <slot/>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    title: {
        type: String,
        default: 'title',
    },
});
</script>
