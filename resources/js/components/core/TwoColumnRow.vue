<template>
    <div class="row mb-2">
        <div class="col-md-4 col-sm-6 text-accent"><span v-html="props.title"></span></div>
        <div class="col-md-8 col-sm-6 fw-bold">
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
