<template>
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
                        <h5 class="mb-0 card-title p-0">Заголовок</h5>
                    </template>
                    <template #body>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Position</th>
                                        <th scope="col">Age</th>
                                        <th scope="col">Start Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Brandon Jacob</td>
                                        <td>Designer</td>
                                        <td>28</td>
                                        <td>2016-05-25</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Bridie Kessler</td>
                                        <td>Developer</td>
                                        <td>35</td>
                                        <td>2014-12-05</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Position</th>
                                        <th scope="col">Age</th>
                                        <th scope="col">Start Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Brandon Jacob</td>
                                        <td>Designer</td>
                                        <td>28</td>
                                        <td>2016-05-25</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Bridie Kessler</td>
                                        <td>Developer</td>
                                        <td>35</td>
                                        <td>2014-12-05</td>
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
                                            Вывод оценок
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
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Position</th>
                                                    <th scope="col">Age</th>
                                                    <th scope="col">Start Date</th>
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
                    </template>
                </TheCard>
            </div>
        </div>
        <Alert v-else class="mt-3"/>
    </template>
    <hr>
    <RouterLink
        :to="{ name: 'Promo.Index' }"
        class="btn btn-secondary my-2"
        role="button"
    >Обратно на Промо-акции
    </RouterLink>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { ADMIN_URLS, MANAGER_URLS } from '@/helpers/constants.js';
import TheSpinner from '@/components/core/TheSpinner.vue';
import Alert from '@/components/Alert.vue';
import TheCard from '@/components/core/TheCard.vue';
import AdminPromoProductItem from '@/pages/PromoActual/AdminPromoProductItem.vue';
import TheButton from '@/components/core/TheButton.vue';

const route = useRoute();
const router = useRouter();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();
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
    await download(`${ ADMIN_URLS.PROMO }/${ promoId }/print`, `promo_${ promoId }_export.pdf`);
};


/**
 "id": 1,
 "userId": 1,
 "status": "ON_APPROVAL",
 "statusColor": "bg-warning",
 "statusLabel": "На согласовании",
 "totalBudgetPlan": "4051.00",
 "totalBudgetActual": "4892.00",
 "totalMark": "3.27",
 "promoType": "DISCOUNT",
 "promoLabel": "Скидка в цене",
 "promoBgColor": "bg-warning",
 "promoCode": "ЖЦ",
 "customerName": "Прайд-А, ООО",
 "retailerName": "Аникс",
 "startDate": "01.02.2025",
 "endDate": "28.02.2025",
 "mark": {
 "id": 1,
 "promo_id": 1,
 "goals": "3.40",
 "sales": "2.20",
 "staff": "4.20",
 "comments": "Мы создали кое-что особенное — товары, вдохновленные славянскими мифами и нашим крипто-будущим! Ваши криптоактивы будут под защитой настоящей магии"
 },
 "channelName": "Сеть",
 "regionCode": "СФО",
 "cityName": "Бийск",
 "comments": "Функция СРЗНАЧ возвращает среднее арифметическое аргументов. С ее помощью на уроке мы посчитали среднюю выручку.",
 "totalSalesBefore": "150.00",
 "totalSalesPlan": "500.00",
 "totalSalesOnTime": "600.00",
 "totalSalesAfter": "0.00",
 "totalPromoProfitPlan": "2738.47",
 "totalPromoProfitActual": "3550.00",
 "createdAt": "2025-01-19T07:25:13.000000Z",
 "updatedAt": "2025-01-20T07:14:10.000000Z"

 ****************************
 *
 "id": 1,
 "promoId": 1,
 "categoryName": "Granmulino Стандарт",
 "productName": "Перья, 400 г",
 "salesBefore": "100",
 "salesPlan": "400",
 "salesOnTime": "400",
 "salesAfter": "0",
 "compensation": "8.04",
 "budgetPlan": "3214.00",
 "budgetActual": "3216.00",
 "profitPerUnit": "4.82",
 "profitPerProductPlan": "1927.58",
 "profitPerProductActual": "1928.00",
 "discount": 20,
 "netProfit": 15,
 "promoPrice": "32.15",
 "surplusPlan": "300.00",
 "surplusActual": "300.00",
 "revenuePlan": "12858.00",
 "revenueActual": "12860.00"
 *
 * */
</script>
