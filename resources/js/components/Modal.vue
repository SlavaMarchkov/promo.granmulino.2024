<template>
    <div
        :id="props.id"
        aria-hidden="true"
        class="modal fade"
        tabindex="-1"
        :aria-labelledby="props.id + 'Label'"
    >
        <div
            :class="modalClasses"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <slot name="title"></slot>
                    </h5>
                    <Button
                        @click="props.closeFunc"
                        type="button"
                        class="btn-close"
                        aria-label="Close"
                    ></Button>
                </div>
                <div class="modal-body">
                    <slot name="body"></slot>
                </div>
                <div class="modal-footer">
                    <slot name="footer"></slot>
                    <Button
                        @click="props.closeFunc"
                        type="button"
                        class="btn-secondary"
                    >Закрыть
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Button from '@/components/core/Button.vue';
import { computed } from 'vue';

const props = defineProps({
    id: {
        type: String,
    },
    closeFunc: Function,
    customClasses: {
        type: Array,
        default: () => [],
    },
});

const baseClasses = [
    'modal-dialog',
];

const modalClasses = computed(() => {
    return [...baseClasses, ...props.customClasses];
});
</script>
