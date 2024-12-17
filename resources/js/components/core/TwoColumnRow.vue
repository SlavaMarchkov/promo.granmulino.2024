<template>
    <div class="row">
        <div :class="firstCol"><span v-html="props.title"></span></div>
        <div :class="['fw-bold text-end', secondCol]">
            <slot/>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        default: 'title',
    },
    cols: {
        type: [Number, String],
        default: 6,
    },
});

const firstCol = computed(() => `col-${props.cols}`);
const secondCol = computed(() => `col-${12 - props.cols}`);
</script>

<style scoped>

</style>
