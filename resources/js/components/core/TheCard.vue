<template>
    <div class="col">
        <div class="card mb-0">
            <div :class="headerClasses">
                <slot name="header"></slot>
            </div>
            <div :class="bodyClasses">
                <slot name="body"></slot>
            </div>
            <div v-if="props.withFooter" :class="footerClasses">
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    headerClasses: {
        type: Array,
        default: () => [],
    },
    bodyClasses: {
        type: Array,
        default: () => [],
    },
    footerClasses: {
        type: Array,
        default: () => [],
    },
    withFooter: {
        type: Boolean,
        default: false,
    },
});

const baseHeaderClasses = [
    'card-header d-flex justify-content-between align-items-center',
];

const baseBodyClasses = [
    'card-body mt-3',
];

const baseFooterClasses = [
    'card-footer',
];

const headerClasses = computed(() => {
    return [...baseHeaderClasses, ...props.headerClasses];
});

const bodyClasses = computed(() => {
    return [...baseBodyClasses, ...props.bodyClasses];
});

const footerClasses = computed(() => {
    return [...baseFooterClasses, ...props.footerClasses];
});
</script>

<style scoped>

</style>
