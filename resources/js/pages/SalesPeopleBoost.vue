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
                        :disabled="filteredSellers.length === 0"
                    >
                        Добавить задание
                    </button>
                </div>
                <hr>
                <div v-if="filteredSellers.length === 0">
                    <p>В команду дистрибьютора не добавлено ни одного торгового представителя. <RouterLink :to="{ name: 'Manager.Customer.View', params: { id: props.customerId }}" class="fw-bold">Перейдите в карточку контрагента</RouterLink> на вкладку "Команда ТП" и добавьте торговых представителей.</p>
                </div>
<!--       TODO         /**
                3. АДРЕСНАЯ ПРОГРАММА:
                №	ТП	Продажи продукции
                факт, руб март	план, руб апрель	факт апрель	% выполнения	мотивация %	факт, руб апрель
                1	Вебер Елена Валентиновна	41 128,00	53466,40	48 642,57	90,98%	10%	4 864,26
                */-->
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
import { computed, reactive, watch } from 'vue';
import { useHttpService } from '@/use/useHttpService.js';
import { MANAGER_URLS } from '@/helpers/constants.js';

const { get } = useHttpService();

const props = defineProps({
    customerId: {
        type: String,
        required: true,
        default: '',
    },
});

const state = reactive({
    sellers: [],
});

watch(
    () => props.customerId,
    async (newValue) => {
        state.sellers = [];
        await getSellers(newValue);
    },
);

const getSellers = async (customerId) => {
    const { status, data } = await get(`${MANAGER_URLS.CUSTOMER}/${customerId}`, {
        params: {
            'customer_sellers': true,
        },
    });
    if (status === 'success') state.sellers = data.customerSellers;
};

const filteredSellers = computed(() => {
    return state.sellers.filter(seller => seller.isActive);
});
</script>
