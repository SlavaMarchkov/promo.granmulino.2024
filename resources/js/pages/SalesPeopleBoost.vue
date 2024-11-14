<template>
    <div>
        <div class="card">
            <div class="card-header bg-secondary text-white">Мотивация торгового персонала</div>
            <div class="card-body mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Участники из команды ТП</span>
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
                <Button
                    @click="addProduct"
                    type="button"
                    class="btn-success w-25"
                    :disabled="!isFormValid"
                >
                    Добавить
                </Button>
            </template>
        </Modal>
    </div>
</template>

<script setup>
import Button from '@/components/core/Button.vue';
import Modal from '@/components/Modal.vue';
</script>
