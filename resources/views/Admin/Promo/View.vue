<template>
    <RouterLink
        :to="{ name: 'Promo.Index' }"
        class="fw-bold"
    ><i class="bi bi-arrow-bar-left me-2"></i>Обратно на Промо-акции
    </RouterLink>
    <hr>
    <div v-if="spinnerStore.isLoading" class="row">
        <div class="col-12">
            <h4 class="my-4"><TheSpinner /></h4>
        </div>
    </div>
    <template v-else>
        <div v-if="isPromoFound" class="row">
            <div class="col-12">
                <TheCard with-footer>
                    <template #header>
                        <h4 class="mb-0"><span :class="[ 'badge', promo.statusColor ]">{{ promo.statusLabel }}</span></h4>
                        <h3 class="mb-0">{{ promo.promoCode }}&nbsp;|&nbsp;<span class="text-secondary fs-5">{{ promo.promoLabel }}&nbsp;|&nbsp;{{ promo.startDate }} - {{ promo.endDate }}</span></h3>
                        <h3 class="mb-0"><span :class="[ 'badge', promoMarkClass(promo.totalMark) ]">{{ promo.totalMark }}</span></h3>
                    </template>
                    <template #body>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Параметр</th>
                                        <th scope="col">Значение</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row" class="text-center">1</th>
                                        <td>Менеджер</td>
                                        <td>{{ promo.userName }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-center">2</th>
                                        <td>Контрагент</td>
                                        <td>{{ promo.customerName }} | г. {{ promo.cityName }} | {{ promo.regionCode }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-center">3</th>
                                        <td>Канал продаж</td>
                                        <td>{{ promo.channelName }} | {{ promo.retailerName }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-striped text-end">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-start">Параметр</th>
                                        <th scope="col">План</th>
                                        <th scope="col">Факт</th>
                                        <th scope="col" class="text-center">Отклонение, %</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row" class="text-center">4</th>
                                        <td class="text-start">Общий бюджет, руб.</td>
                                        <td>{{ formatNumber(promo.totalBudgetPlan) }}</td>
                                        <td>{{ formatNumber(promo.totalBudgetActual) }}</td>
                                        <td :class="['text-center fw-bold', calcDiffPercentColor(calcBudgetDiffPercent)]" v-html="formatAsPercent(calcBudgetDiffPercent)"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-center">5</th>
                                        <td class="text-start">Общие продажи, шт.</td>
                                        <td>{{ formatNumber(promo.totalSalesPlan) }}</td>
                                        <td>{{ formatNumber(promo.totalSalesOnTime) }}</td>
                                        <td :class="['text-center fw-bold', calcDiffPercentColorInverse(calcSalesDiffPercent)]" v-html="formatAsPercent(calcSalesDiffPercent)"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-center">6</th>
                                        <td class="text-start">Общая прибыль, руб.</td>
                                        <td>{{ formatNumber(promo.totalPromoProfitPlan) }}</td>
                                        <td>{{ formatNumber(promo.totalPromoProfitActual) }}</td>
                                        <td :class="['text-center fw-bold', calcDiffPercentColorInverse(calcPromoProfitDiffPercent)]" v-html="formatAsPercent(calcPromoProfitDiffPercent)"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
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
                                            <div class="bd-callout bd-callout-warning mb-0">
                                                <p class="mb-0">{{ promo.comments }}</p>
                                            </div>
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
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-0">Цель промо-акции: <span class="fw-bold fs-5">{{ formatNumberWithFractions(promo.mark.goals) }}</span></p>
                                                    <TheProgressBar
                                                        class="mb-2"
                                                        :now="promo.mark.goals"
                                                    />
                                                    <p class="mb-0">Продажи: <span class="fw-bold fs-5">{{ formatNumberWithFractions(promo.mark.sales) }}</span></p>
                                                    <TheProgressBar
                                                        class="mb-2"
                                                        :now="promo.mark.sales"
                                                    />
                                                    <p class="mb-0">Участие персонала: <span class="fw-bold fs-5">{{ formatNumberWithFractions(promo.mark.staff) }}</span></p>
                                                    <TheProgressBar
                                                        :now="promo.mark.staff"
                                                    />
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>Выводы по промо-акции</h5>
                                                    <div class="bd-callout bd-callout-warning mb-0">
                                                        <p class="mb-0">{{ promo.mark.comments }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item" v-if="products.length > 0">
                                    <h2
                                        id="promoProducts"
                                        class="accordion-header"
                                    >
                                        <button aria-controls="collapsePromoProducts" aria-expanded="true" class="accordion-button"
                                                data-bs-target="#collapsePromoProducts" data-bs-toggle="collapse"
                                                type="button">
                                            <span class="card-title p-0 m-0">Акционная продукция</span>
                                        </button>
                                    </h2>
                                    <div id="collapsePromoProducts" aria-labelledby="promoProducts"
                                         class="accordion-collapse collapse show" data-bs-parent="#promoDetails">
                                        <div class="accordion-body">
                                            <table class="table table-striped text-center align-middle">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col" class="text-start">Продукт</th>
                                                    <th scope="col">Скидка, %</th>
                                                    <th scope="col">ЧП, %</th>
                                                    <th scope="col">Продажи, шт.</th>
                                                    <th scope="col">Бюджет, руб.</th>
                                                    <th scope="col">Компенсация</th>
                                                    <th scope="col">Прибыль, руб/шт</th>
                                                    <th scope="col">Прирост, %</th>
                                                    <th scope="col">Выручка, руб.</th>
                                                    <th scope="col">Отклонение</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <AdminPromoProductItem
                                                    v-for="(product, index) in products"
                                                    :key="product.id"
                                                    :index="index"
                                                    :product="product"
                                                />
                                                </tbody>
                                            </table>
                                            <div class="text-muted" style="font-size: small;">
                                                <p class="mb-0">Примечания к таблице:</p>
                                                <p class="mb-0">1. Верхняя цифра в строке таблицы - это плановое значение, нижняя - фактическое значние.</p>
                                                <p class="mb-0">2. Отклонение - это разница в % между продажами "Во время" и планом продаж.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template #footer>
                        <TheButton
                            class="btn-danger"
                            @click.prevent="exportToPDF"
                        >Экспорт в PDF
                        </TheButton>
                        <div>
                            <div class="input-group">
                                <select v-model="promo.status" class="form-select">
                                    <option disabled selected value="">-- Выберите статус --</option>
                                    <option
                                        v-for="status in PROMO_STATUSES"
                                        :key="status.id"
                                        :value="status.id"
                                    >{{ status.name }}
                                    </option>
                                </select>
                                <TheButton
                                    @click="changePromoStatus"
                                    class="d-inline btn-primary"
                                >Обновить статус</TheButton>
                            </div>
                        </div>
                    </template>
                </TheCard>
            </div>
        </div>
        <Alert v-else class="mt-3"/>
    </template>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import { useCalculations } from '@/use/useCalculations.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { ADMIN_URLS, MANAGER_URLS, PROMO_STATUSES } from '@/helpers/constants.js';
import TheSpinner from '@/components/core/TheSpinner.vue';
import Alert from '@/components/Alert.vue';
import TheCard from '@/components/core/TheCard.vue';
import AdminPromoProductItem from '@/pages/PromoActual/AdminPromoProductItem.vue';
import TheButton from '@/components/core/TheButton.vue';
import { formatAsPercent, formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';
import TheProgressBar from '@/components/core/TheProgressBar.vue';

const route = useRoute();
const router = useRouter();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();
const { promoMarkClass, calcDifferencePercentage, calcDiffPercentColor, calcDiffPercentColorInverse } = useCalculations();
const { get, print, download, update } = useHttpService();
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
    const { status, data } = await get(`${ ADMIN_URLS.PROMO }/${ promoId }`);
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
    const { status, data } = await get(`${ MANAGER_URLS.PROMO }/${ promoId }${ MANAGER_URLS.PRODUCT }`);
    if ( status === 'success' ) products.value = data;
};

const fetchPromoSellers = async (promoId) => {
    const { status, data } = await get(`${ MANAGER_URLS.PROMO }/${ promoId }${ MANAGER_URLS.SELLER }`);
    if ( status === 'success' ) sellers.value = data;
};

const exportToPDF = async () => {
    await print(`${ ADMIN_URLS.PROMO }/${ promoId }/print`, `promo_${ promoId }_export.pdf`);
};

const changePromoStatus = async () => {
    const updatedPromo = {
        status: promo.value.status,
    };
    const response = await update(`${ ADMIN_URLS.PROMO }/${ promoId }`, updatedPromo);
    if ( response && response.status === 'success' ) {
        promo.value.status = response.data.status;
        promo.value.statusColor = response.data.statusColor;
        promo.value.statusLabel = response.data.statusLabel;
    }
};

const calcBudgetDiffPercent = computed(() => {
    return calcDifferencePercentage(promo.value.totalBudgetPlan, promo.value.totalBudgetActual);
});

const calcSalesDiffPercent = computed(() => {
    return calcDifferencePercentage(promo.value.totalSalesPlan, promo.value.totalSalesOnTime);
});

const calcPromoProfitDiffPercent = computed(() => {
    return calcDifferencePercentage(promo.value.totalPromoProfitPlan, promo.value.totalPromoProfitActual);
});
</script>
