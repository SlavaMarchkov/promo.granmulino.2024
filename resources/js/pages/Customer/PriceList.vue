<template>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="card-title p-0 mb-0">Продуктовая матрица контрагента</h4>
        <TheButton
            @click="saveProducts"
            :class="[
                'btn-success w-25',
                { 'btn-cursor-not-allowed' : addedProducts.length === 0 }
            ]"
            :disabled="spinnerStore.isButtonDisabled || addedProducts.length === 0"
        >Сохранить</TheButton>
    </div>
    <div class="bd-callout bd-callout-warning mb-3">
        <p class="fw-bold">Укажите цену для каждого формата, включая НДС.</p>
        <p class="mb-0">Шаг 1. В поле Цена, руб. введите нужное значение.<br>
            Шаг 2. Поставьте галочку рядом с названием формата.<br>
            Шаг 3. Сохраните изменения.</p>
    </div>
    <div class="accordion" id="categoriesAccordion">
        <div
            v-for="category in props.categories"
            class="accordion-item"
        >
            <h2 class="accordion-header" :id="`category${ category.id }`">
                <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    :data-bs-target="`#collapse${ category.id }`"
                    aria-expanded="false"
                    :aria-controls="`collapse${ category.id }`"
                >
                    {{ category.name }} - {{ countListedProducts(category.products) }} из {{ category.count }}
                </button>
            </h2>
            <div
                :id="`collapse${ category.id }`"
                class="accordion-collapse collapse"
                :aria-labelledby="`category${ category.id }`"
                data-bs-parent="#categoriesAccordion"
                style=""
            >
                <div class="accordion-body">
                    <ul class="list-group">
                        <li class="list-group-item m-0">
                            <div class="row g-2 text-center align-items-center p-0">
                                <div class="col-md-5">Наименование</div>
                                <div class="col-md-3">Цена, руб.</div>
                                <div class="col-md-4">Дата и время обновления</div>
                            </div>
                        </li>
                        <PriceListItem
                            v-for="product in sortArrayByStringColumn(category.products, 'name')"
                            :category-id="category.id"
                            :product="product"
                            @update-product="addProductToMatrix"
                        />
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useHttpService } from '@/use/useHttpService.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import PriceListItem from '@/pages/Customer/PriceListItem.vue';
import TheButton from '@/components/core/TheButton.vue';
import { MANAGER_URLS } from '@/helpers/constants.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';

const { get, post } = useHttpService();
const spinnerStore = useSpinnerStore();
const alertStore = useAlertStore();
const { sortArrayByStringColumn } = useArrayHandlers();

const props = defineProps({
    customerId: {
        type: Number,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
        default: () => [],
    },
});

const emit = defineEmits([
    'updateCategories',
]);

const addedProducts = ref([]);

const addProductToMatrix = (product) => {
    const idx = addedProducts.value.findIndex(pr => pr.productId === product.productId);
    idx === -1 ? addedProducts.value.push(product) : addedProducts.value[idx] = product;
};

const saveProducts = async () => {
    const response = await post(`${ MANAGER_URLS.CUSTOMER }/${ props.customerId }${ MANAGER_URLS.PRODUCT }`, addedProducts.value);
    if ( response && response.status === 'success' ) {
        emit('updateCategories', response.data.products);
        addedProducts.value = [];
    }
};

const countListedProducts = (products) => {
    return products.reduce((acc, product) => product.isListed ? acc + 1 : acc, 0);
}
</script>
