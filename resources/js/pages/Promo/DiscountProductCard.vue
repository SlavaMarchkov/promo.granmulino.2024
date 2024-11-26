<template>
    <div
        v-for="(pr, index) in props.products"
        class="col"
        :key="index"
    >
        <div class="card mb-0">
            <h6 class="card-header bg-secondary-subtle py-2 fw-bold text-black">{{ pr.categoryName }}</h6>
            <h6 class="card-header py-2 fw-bold text-primary">{{ pr.productName }}</h6>
            <div class="card-body mt-2 pb-2">
                <div class="row">
                    <div class="col-7">Продажи "До"</div>
                    <div class="col-5 fw-bold text-end">{{ formatNumber(pr.salesBefore) }} шт.</div>
                </div>
                <div class="row">
                    <div class="col-6">План</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(pr.salesPlan) }} шт.</div>
                </div>
                <div class="row">
                    <div class="col-7">Прирост</div>
                    <div class="col-5 fw-bold text-end">{{ formatNumber(pr.surplusPlan) }}&#8239;%</div>
                </div>
                <div class="row">
                    <div class="col-6">Бюджет</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(pr.budgetPlan) }} руб.</div>
                </div>
            </div>
            <div class="card-footer py-2">
                <TheButton
                    class="btn-danger w-100"
                    @click="removeProduct(index)"
                >Удалить</TheButton>
            </div>
        </div>
    </div>
</template>

<script setup>
import { formatNumber } from '@/helpers/formatters.js';
import TheButton from '@/components/core/TheButton.vue';

const props = defineProps({
    products: {
        type: Array,
        required: true,
        default: [],
    },
});

const emit = defineEmits([
    'removeProduct',
]);

const removeProduct = (productIndex) => {
    emit('removeProduct', productIndex);
};
</script>
