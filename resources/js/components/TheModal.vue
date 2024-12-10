<template>
    <teleport to=".modals">
        <div
            :id="props.id"
            :class="[
                'modal fade',
                { 'show d-block' : modelValue === true }
            ]"
            tabindex="-1"
        >
            <div :class="modalClasses">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <slot name="title"></slot>
                        </h5>
                        <TheButton
                            @click="closeModal"
                            type="button"
                            class="btn-close"
                            aria-label="Close"
                        ></TheButton>
                    </div>
                    <div class="modal-body">
                        <slot name="body"></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer"></slot>
                        <TheButton
                            @click="closeModal"
                            type="button"
                            class="btn-secondary"
                        >Закрыть
                        </TheButton>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
</template>

<script setup>
import { computed, onMounted, onUnmounted } from 'vue';
import TheButton from '@/components/core/TheButton.vue';

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false,
    },
    id: {
        type: String,
        required: true,
    },
    customClasses: {
        type: Array,
        default: () => [],
    },
});

const body = document.querySelector('body');
const div = document.createElement('div');
div.classList.add('modal-backdrop', 'fade', 'show');

const handleKeyboard = (evt) => {
    if (evt.key === 'Escape') {
        closeModal();
    }
};

onMounted(() => {
    body.classList.add('modal-open');
    body.style.overflow = 'hidden';
    body.appendChild(div);
    document.addEventListener('keyup', handleKeyboard);
});

onUnmounted(() => {
    body.classList.remove('modal-open');
    body.style.removeProperty('overflow');
    body.removeChild(div);
    document.removeEventListener('keyup', handleKeyboard);
});

const emit = defineEmits([
    'update:modelValue',
]);

const closeModal = () => {
    emit('update:modelValue', false);
};

const baseClasses = [
    'modal-dialog',
];

const modalClasses = computed(() => {
    return [...baseClasses, ...props.customClasses];
});
</script>
