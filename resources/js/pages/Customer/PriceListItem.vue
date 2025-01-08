<template>
    <li class="list-group-item m-0">
        <div class="row g-2 align-items-center p-0">
            <div class="col-md-5">
                <div class="input-group">
                    <div class="input-group-text">
                        <input
                            class="form-check-input mt-0"
                            type="checkbox"
                            v-model="state.form.isListed"
                            @change="onIsListedChange"
                            :tabindex="-1"
                        />
                    </div>
                    <TheInput
                        :model-value="props.product.name"
                        readonly="readonly"
                        :tabindex="-1"
                    />
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text">&#8381;</span>
                    <TheInput
                        class="text-center"
                        v-model="state.form.customerPrice"
                        @input="state.form.isListed = false"
                    />
                    <span class="input-group-text">00,00</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                    <TheInput
                        class="text-center"
                        v-model="state.form.updatedAt"
                        readonly="readonly"
                        :tabindex="-1"
                    />
                    <span class="input-group-text"><i class="bi bi-clock"></i></span>
                </div>
            </div>
        </div>
    </li>
</template>

<script setup>
import TheInput from '@/components/form/TheInput.vue';
import { reactive } from 'vue';
import { convertInputStringToNumber, formatNumberWithFractions } from '@/helpers/formatters.js';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    categoryId: {
        type: Number,
        required: true,
    },
});

const emit = defineEmits([
    'updateProduct',
]);

const initialFormData = () => ({
    customerId: props.product.customerId,
    categoryId: props.categoryId,
    productId: props.product.id,
    customerPrice: props.product.customerPrice ? formatNumberWithFractions(props.product.customerPrice) : '',
    isListed: props.product.isListed ?? false,
    updatedAt: props.product.updatedAt ?? '',
});

const state = reactive({
    form: initialFormData(),
});

const onIsListedChange = () => {
    const price = convertInputStringToNumber(state.form.customerPrice);
    if ( isNaN(price) ) {
        state.form.customerPrice = '';
        state.form.isListed = false;
        alert('Неверный формат цены продукта!');
        return;
    }
    state.form.customerPrice = formatNumberWithFractions(price);
    const updatedAt = new Date();
    state.form.updatedAt = updatedAt.toLocaleDateString() + ' в ' + updatedAt.toLocaleTimeString();
    emit('updateProduct', state.form);
};
</script>
