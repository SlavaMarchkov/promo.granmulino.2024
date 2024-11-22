<template>
    <div>
        <div class="card">
            <div class="card-header bg-info text-white">{{ props.title }}</div>
            <div class="card-body mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Список торговых точек</span>
                    <button
                        @click="addProductModalInit"
                        class="btn btn-success"
                        type="button"
                    >
                        Добавить
                    </button>
                </div>
                <hr>
            </div>
        </div>
        <Modal
            id="modalPopUp"
            :close-func="closeModal"
            :custom-classes="['modal-lg']"
        >
            <template #title>
                Добавление ассортимента для промо-акции
            </template>
            <template #body>
                <div class="row g-3">

                </div>
            </template>
            <template #footer>
                <TheButton
                    @click="addProduct"
                    type="button"
                    class="btn-success w-25"
                    :disabled="!isFormValid"
                >
                    Добавить
                </TheButton>
            </template>
        </Modal>
    </div>
</template>

<script setup>
import TheButton from '@/components/core/TheButton.vue';
import Modal from '@/components/Modal.vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
        default: 'Title is required',
    },
});
</script>
