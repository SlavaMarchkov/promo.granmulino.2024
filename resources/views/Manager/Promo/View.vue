<template>
    <div v-if="spinnerStore.isLoading" class="row">
        <div class="col-12">
            <h4 class="my-4"><TheSpinner /></h4>
        </div>
    </div>
    <template v-else>
        <div v-if="isPromoFound" class="row promo-view">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ promo.promoCode }}{{ promo.discount !== null ? `-${promo.discount}` : '' }}&nbsp;<span
                            class="text-secondary fs-5">|&nbsp;{{ promo.channelName }}</span></h3>
                        <h4 class="mb-0"><span :class="[ 'badge', promo.statusColor ]">{{ promo.statusLabel }}</span></h4>
                        <h2 class="mb-0"><span :class="[ 'badge', promoMarkBgColor ]">{{ promo.totalMark }}</span></h2>
                    </div>
                    <div class="card-body mt-2 g-3">
                        <div class="row mb-2">
                            <div class="col-4">
                                <div class="mb-0 alert border-primary">
                                    <h5 class="mb-0 text-secondary">Дистрибутор: <span
                                        class="fw-bold text-accent">{{ promo.customerName }}</span></h5>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-0 alert border-success" role="alert">
                                    <h5 class="mb-0 text-secondary">Сеть: <span
                                        class="fw-bold text-accent">{{ promo.retailerName ?? '&mdash;' }}</span></h5>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-0 alert border-info" role="alert">
                                    <h5 class="mb-0 text-secondary">Период: <span
                                        class="fw-bold text-accent">{{ promo.startDate }} - {{ promo.endDate }}</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <ProductCards
                                v-if="promo.promoType === 'DISCOUNT'"
                                :total-budget-plan="promo.totalBudgetPlan"
                                :total-budget-actual="promo.totalBudgetActual"
                                :total-sales-before="promo.totalSalesBefore"
                                :total-sales-on-time="promo.totalSalesOnTime"
                                :total-sales-plan="promo.totalSalesPlan"
                                :total-promo-profit="promo.totalPromoProfit"
                            ></ProductCards>
                            <SalesCards
                                v-if="promo.promoType === 'SALES_PEOPLE_BOOST'"
                                :total-budget-plan="promo.totalBudgetPlan"
                                :total-budget-actual="promo.totalBudgetActual"
                                :total-sales-before="promo.totalSalesBefore"
                                :total-sales-plan="promo.totalSalesPlan"
                                :total-sales-after="promo.totalSalesAfter"
                            ></SalesCards>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div id="promoDetails" class="accordion">
                            <div class="accordion-item">
                                <h2
                                    id="promoComments"
                                    class="accordion-header"
                                >
                                    <button aria-controls="collapsePromoComments" aria-expanded="false" class="accordion-button collapsed"
                                            data-bs-target="#collapsePromoComments" data-bs-toggle="collapse"
                                            type="button">
                                        <span class="card-title p-0 m-0">Механика промо-акции</span>
                                    </button>
                                </h2>
                                <div id="collapsePromoComments" aria-labelledby="promoComments"
                                     class="accordion-collapse collapse" data-bs-parent="#promoDetails">
                                    <div class="accordion-body">
                                        {{ promo.comments }}
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2
                                    id="promoMark"
                                    class="accordion-header"
                                >
                                    <button aria-controls="collapsePromoMark" aria-expanded="false" class="accordion-button collapsed"
                                            data-bs-target="#collapsePromoMark" data-bs-toggle="collapse"
                                            type="button">
                                        <span class="card-title p-0 m-0">Оценки промо-акции</span>
                                    </button>
                                </h2>
                                <div id="collapsePromoMark" aria-labelledby="promoMark"
                                     class="accordion-collapse collapse" data-bs-parent="#promoDetails">
                                    <div class="accordion-body">
                                        <Alert />
                                        <PromoMark
                                            :mark="promo.mark"
                                            @update-promo-mark="updatePromoMark"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="products.length > 0" class="col-12">
                <TheCard>
                    <template #header><h4 class="mb-0">Акционная продукция</h4></template>
                    <template #body>
                        <div class="row flex-column g-3">
                            <PromoProductItem
                                v-for="(product, index) in products"
                                :key="product.id"
                                :index="index"
                                :product="product"
                                :promo-id="promoId"
                                @update-product-item="updatePromoProduct"
                            />
                        </div>
                    </template>
                </TheCard>
            </div>
            <div v-if="sellers.length > 0" class="col-12">
                <TheCard>
                    <template #header>
                        <h4 class="mb-0">Мотивация команды ТП</h4>
                        <TheButton
                            @click="updatePromo"
                            :class="[
                                'btn-success',
                                { 'btn-cursor-not-allowed' : !isFormValid() }
                            ]"
                            :disabled="spinnerStore.isButtonDisabled || !isFormValid()"
                            :loading="spinnerStore.isButtonDisabled"
                        >Сохранить изменения</TheButton>
                    </template>
                    <template #body>
                        <Alert />
                        <SalesPeopleBoost
                            :items="sellers"
                            :promo="promo"
                            @update-promo-sellers="preparePromoSellersForUpdate"
                        />
                    </template>
                </TheCard>
            </div>
        </div>
        <Alert v-else class="mt-3"/>
    </template>
    <hr>
    <RouterLink
        :to="{ name: 'Manager.Promo.Index' }"
        class="btn btn-secondary my-2"
        role="button"
    >Обратно на Мои Промо-акции
    </RouterLink>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { MANAGER_URLS } from '@/helpers/constants.js';
import Alert from '@/components/Alert.vue';
import TheSpinner from '@/components/core/TheSpinner.vue';
import PromoProductItem from '@/pages/Promo/PromoProductItem.vue';
import TheCard from '@/components/core/TheCard.vue';
import PromoMark from '@/pages/Promo/PromoMark.vue';
import ProductCards from '@/pages/PromoActual/ProductCards.vue';
import SalesCards from '@/pages/PromoActual/SalesCards.vue';
import SalesPeopleBoost from '@/pages/PromoActual/SalesPeopleBoost.vue';
import TheButton from '@/components/core/TheButton.vue';
import { useConvertCase } from '@/use/useConvertCase.js';

const route = useRoute();
const router = useRouter();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();
const { makeConvertibleObject, toCamel } = useConvertCase();

const { get, update } = useHttpService();
const promoId = +route.params.id;

const promo = ref({});
const products = ref([]);
const sellers = ref([]);
const updatedPromo = ref({
    promo: null,
    sellers: null,
});

onMounted(async () => {
    await fetchDetails(promoId);
});

const isPromoFound = computed(() => {
    return Object.keys(promo.value).length !== 0;
});

const fetchDetails = async (promoId) => {
    const { status, data } = await get(`${MANAGER_URLS.PROMO}/${promoId}`);
    if ( status === 'success' ) promo.value = data;
};

watch(
    () => promo.value.promoType,
    (type) => {
        switch ( type ) {
            case 'DISCOUNT':
                fetchPromoProducts(promoId);
                break;
            case 'SALES_PEOPLE_BOOST':
                fetchPromoSellers(promoId);
                break;
        }
    },
);

const isFormValid = () => {
    return Object.keys(updatedPromo.value).length !== 0;
};

const fetchPromoProducts = async (promoId) => {
    const { status, data } = await get(`${ MANAGER_URLS.PROMO }/${ promoId }${ MANAGER_URLS.PRODUCT }`);
    if ( status === 'success' ) products.value = data;
};

const fetchPromoSellers = async (promoId) => {
    const { status, data } = await get(`${ MANAGER_URLS.PROMO }/${ promoId }${ MANAGER_URLS.SELLER }`);
    if ( status === 'success' ) sellers.value = data;
};

const updatePromoProduct = (data) => {
    const idx = products.value.findIndex(pr => pr.id === data.product.id);
    products.value[idx] = {
        ...products.value[idx],
        ...data.product,
    };
    promo.value = {
        ...promo.value,
        ...data.promo,
    };
};

const updatePromoMark = async (mark) => {
    const response = await update(`${ MANAGER_URLS.PROMO }/${ promoId }${ MANAGER_URLS.MARK }/${ mark.id }`, mark);
    if ( response && response.status === 'success' ) {
        promo.value = { ...response.data };
    }
};

const updatePromo = async () => {
    const response = await update(`${ MANAGER_URLS.PROMO }/${ promoId }`, updatedPromo.value);
    if ( response && response.status === 'success' ) {
        const data = makeConvertibleObject(JSON.parse(response.data), toCamel);
        promo.value = {
            ...promo.value,
            ...data.promo,
        };
        sellers.value = {
            ...data.sellers,
        };
    }
};

const preparePromoSellersForUpdate = (promoObj, sellersArr) => {
    updatedPromo.value.promo = promoObj;
    updatedPromo.value.sellers = sellersArr;
};

const promoMarkBgColor = computed(() => {
    return promo.value.totalMark > 0 && promo.value.totalMark <= 3
        ? 'bg-danger'
        : promo.value.totalMark > 3 && promo.value.totalMark <= 5
            ? 'bg-success' : 'bg-secondary';
});
</script>
