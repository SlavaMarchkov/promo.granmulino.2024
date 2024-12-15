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
                    <div class="card-header bg-light d-flex justify-content-between">
                        <h3 class="mb-0">{{ promo.promoCode }}{{ promo.discount !== null ? `-${promo.discount}` : '' }}</h3>
                        <h4 class="mb-0"><span :class="[ 'badge', promo.statusColor ]">{{ promo.statusLabel }}</span></h4>
                    </div>
                    <div class="card-body pt-4 d-flex">
                        <div class="col-3">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <h5 class="card-title">Место проведения <span>| Канал продаж</span></h5>
                                    <div class="d-flex align-items-center">
                                        Контрагент
                                        Торговая сеть
                                        Регион
                                        Город
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <h5 class="card-title">Даты проведения</h5>
                                    <div class="d-flex align-items-center">
                                        Дата начала
                                        Дата окончания
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <h5 class="card-title">Бюджет</h5>
                                    <div class="d-flex align-items-center">
                                        План
                                        Факт
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <h5 class="card-title">Общая прибыль</h5>
                                    <div class="d-flex align-items-center">
                                        Прибыль
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="accordion" id="promoComments">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <span class="card-title p-0 m-0">Механика промо-акции</span>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#promoComments">
                                    <div class="accordion-body">
                                        {{ promo.comments }}
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <span class="card-title p-0 m-0">Оценки промо-акции</span>
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#promoComments">
                                    <div class="accordion-body">
                                        <div class="row mb-4">
                                            <div class="col-3">
                                                <label for="promo_goals" class="form-label">Цель промо-акции: <span class="fw-bold fs-5">3.5</span></label>
                                                <input type="range" class="form-range" min="0" max="5" step="0.5" id="promo_goals">
                                            </div>
                                            <div class="col-3">
                                                <label for="promo_sales" class="form-label">Продажи: <span class="fw-bold fs-5">3.5</span></label>
                                                <input type="range" class="form-range" min="0" max="5" step="0.5" id="promo_sales">
                                            </div>
                                            <div class="col-3">
                                                <label for="promo_staff" class="form-label">Участие персонала: <span class="fw-bold fs-5">3.5</span></label>
                                                <input type="range" class="form-range" min="0" max="5" step="0.5" id="promo_staff">
                                            </div>
                                            <div class="col-3 text-center">
                                                <label for="promo_mark" class="form-label">Итоговая оценка</label>
                                                <input type="text" class="form-control text-center fw-bold" id="promo_mark" value="3.5">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-floating">
                                                    <textarea
                                                        class="form-control border border-dark"
                                                        placeholder="Укажите здесь свои выводы по промо-акции"
                                                        id="promo_comments"
                                                        style="height: 60px;"
                                                    ></textarea>
                                                    <label for="promo_comments">Выводы по промо-акции</label>
                                                </div>
                                            </div>
                                            <div class="col-6 align-content-center">
                                                <TheButton
                                                    class="btn-primary"
                                                >Сохранить оценку и выводы</TheButton>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="products.length > 0" class="col-12">
                <div class="card">
                    <div class="card-header"><h4 class="mb-0">Акционная продукция</h4></div>
                    <div class="card-body mt-2 row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3">
                        <PromoProductItem
                            v-for="(product, index) in products"
                            :key="product.id"
                            :index="index"
                            :product="product"
                        />
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
import TheButton from '@/components/core/TheButton.vue';

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
