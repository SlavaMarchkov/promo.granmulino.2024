<template>
    <div class="col">
        <div class="card mb-0">
            <h6 class="card-header bg-secondary-subtle py-2 fw-bold text-black">
                {{ props.product.categoryName }}</h6>
            <h6 class="card-header py-2 fw-bold text-primary">
                {{ props.product.productName }}
            </h6>
            <div class="card-body mt-2 pb-2">
                <div class="row">
                    <div class="col-7">Продажи "До"</div>
                    <div class="col-5 fw-bold text-end">{{ formatNumber(props.product.salesBefore) }} шт.</div>
                </div>
                <div class="row">
                    <div class="col-6">План</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(props.product.salesPlan) }} шт.</div>
                </div>
                <div class="row">
                    <div class="col-7">Прирост</div>
                    <div class="col-5 fw-bold text-end">{{ formatNumber(props.product.surplusPlan) }}&#8239;%</div>
                </div>
                <div class="row">
                    <div class="col-6">Бюджет</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(props.product.budgetPlan) }} руб.</div>
                </div>
            </div>
            <div class="card-footer py-2">
                <TheButton
                    class="btn-danger w-100"
                    @click="removeProduct"
                >Удалить</TheButton>
            </div>
        </div>
    </div>
</template>

<script setup>
import { formatNumber } from '@/helpers/formatters.js';
import TheButton from '@/components/core/TheButton.vue';

const props = defineProps({
    index: {
        type: Number,
        default: 1,
    },
    product: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits([
    'removeProduct',
]);

const removeProduct = () => {
    emit('removeProduct', props.index);
};
</script>
