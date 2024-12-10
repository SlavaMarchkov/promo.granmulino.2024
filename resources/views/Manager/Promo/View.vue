<template>
    <div v-if="spinnerStore.isLoading" class="row">
        <div class="col-12">
            <h4 class="my-4"><TheSpinner /></h4>
        </div>
    </div>
    <template v-else>
        <div v-if="isPromoFound" class="row profile">
            <div class="col-12">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column">
                        <h1 class="mb-3">kdkdkdk</h1>
                    </div>
                </div>
            </div>
            <div v-if="products.length > 0" class="col-12">
                <div class="card">
                    <div class="card-header"><h4 class="mb-0">Акционная продукция</h4></div>
                    <div class="card-body">
                        <ul class="list-group">
                            <PromoProductItem
                                v-for="(product, index) in products"
                                :key="product.id"
                                :index="index"
                                :product="product"
                            />
                        </ul>
                    </div>
                </div>
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

const route = useRoute();
const router = useRouter();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();

const { get } = useHttpService();
const promoId = +route.params.id;

const promo = ref({});
const products = ref([]);
const sellers = ref([]);

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

const fetchPromoProducts = async (promoId) => {
    const { status, data } = await get(`${MANAGER_URLS.PROMO}/${promoId}${MANAGER_URLS.PRODUCT}`, {
        params: {
            category: true,
            product: true,
        },
    });
    if ( status === 'success' ) products.value = data;
};

const fetchPromoSellers = async (promoId) => {
    const { status, data } = await get(`${MANAGER_URLS.PROMO}/${promoId}${MANAGER_URLS.SELLER}`);
    if ( status === 'success' ) sellers.value = data;
};
</script>
