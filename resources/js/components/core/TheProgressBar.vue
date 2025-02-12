<template>
    <div class="progress" style="height: 12px;">
        <div
            :class="progressBarClasses"
            role="progressbar"
            :style="styles"
            :aria-valuenow="props.now"
            :aria-valuemin="props.min"
            :aria-valuemax="props.max"
        ></div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    min: {
        type: Number,
        default: 0,
    },
    max: {
        type: Number,
        default: 5,
    },
    now: {
        type: String,
        default: '1.0',
    },
});

const baseClasses = [
    'progress-bar',
    'progress-bar-striped',
    'progress-bar-animated',
];

const progressBarClasses = computed(() => {
    return [...baseClasses, customClasses.value];
});

const percentWidth = computed(() => {
    return (parseFloat(props.now) / props.max) * 100;
});

const styles = computed(() => {
    return 'width: ' + percentWidth.value + '%';
});

const customClasses = computed(() => {
    return percentWidth.value <= 48
        ? 'bg-danger'
        : percentWidth.value >= 78
            ? 'bg-success'
            : 'bg-warning';
});
</script>
