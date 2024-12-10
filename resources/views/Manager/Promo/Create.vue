<template>
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header bg-primary text-white">Укажите общие данные промо-акции</div>
                <div class="card-body mt-3">
                    <Alert/>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <TheLabel for="promo_type" required>Вид промо-акции</TheLabel>
                            <select
                                v-model="state.promo.promoType"
                                id="promo_type"
                                class="form-select"
                            >
                                <option disabled selected value="">- Выберите вид промо-акции -</option>
                                <option
                                    v-for="promo in PROMO_TYPES"
                                    :key="promo.id"
                                    :value="promo.type"
                                >{{ promo.title }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <TheLabel
                                for="discount"
                                :required="currentPromoType.type === 'DISCOUNT'"
                            >Величина скидки</TheLabel>
                            <div class="input-group">
                                <TheInput
                                    id="discount"
                                    v-model="state.promo.discount"
                                    type="number"
                                    min="5"
                                    step="1"
                                    max="50"
                                    :disabled="currentPromoType.type !== 'DISCOUNT'"
                                />
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <TheLabel for="user_id">Менеджер</TheLabel>
                            <TheInput
                                id="user_id"
                                type="text"
                                :value="authUser.fullName"
                                disabled="disabled"
                            />
                        </div>
                        <div class="col-md-6">
                            <TheLabel
                                for="channel_id"
                                :required="currentPromoType.type !== ''"
                            >Канал продаж</TheLabel>
                            <select
                                v-model="state.promo.channelId"
                                id="channel_id"
                                class="form-select"
                                :disabled="currentPromoType.type === ''"
                            >
                                <option disabled selected value="">- Выберите канал продаж -</option>
                                <option
                                    v-for="channel in state.channels"
                                    :key="channel.id"
                                    :value="channel.id"
                                >{{ channel.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <TheLabel
                                for="customer_id"
                                :required="currentPromoType.type !== ''"
                            >Дистрибутор</TheLabel>
                            <select
                                v-model="state.promo.customerId"
                                id="customer_id"
                                class="form-select"
                                :disabled="currentPromoType.type === ''"
                            >
                                <option disabled selected value="">- Выберите дистрибутора -</option>
                                <option
                                    v-for="customer in sortedCustomers"
                                    :key="customer.id"
                                    :value="customer.id"
                                >{{ customer.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <TheLabel
                                for="retailer_id"
                                :required="state.retailers.length > 0 && currentPromoType.isForRetail === true"
                            >Торговая сеть</TheLabel>
                            <select
                                v-model="state.promo.retailerId"
                                id="retailer_id"
                                class="form-select"
                                :disabled="state.retailers.length === 0 || !currentPromoType.isForRetail"
                            >
                                <option disabled selected value="">- Выберите торговую сеть -</option>
                                <option
                                    v-for="retailer in state.retailers"
                                    :key="retailer.id"
                                    :value="retailer.id"
                                >{{ retailer.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <TheLabel for="region_id" required>Регион</TheLabel>
                            <select
                                v-model="state.promo.regionId"
                                id="region_id"
                                class="form-select"
                                disabled="disabled"
                            >
                                <option disabled selected value="">- Выберите регион -</option>
                                <option
                                    v-for="region in regions"
                                    :key="region.id"
                                    :value="region.id"
                                    :selected="state.promo.regionId"
                                >{{ region.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <TheLabel for="city_id" required>Город</TheLabel>
                            <select
                                v-model="state.promo.cityId"
                                id="city_id"
                                class="form-select"
                                disabled="disabled"
                            >
                                <option disabled selected value="">- Выберите город -</option>
                                <option
                                    v-for="city in cities"
                                    :key="city.id"
                                    :value="city.id"
                                    :selected="state.promo.cityId"
                                >{{ city.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <TheLabel for="start_date" required>Начало промо-акции</TheLabel>
                            <TheInput
                                id="start_date"
                                type="text"
                                readonly="readonly"
                                aria-describedby="start_date_help"
                            />
                            <div id="start_date_help" class="form-text">укажите дату начала акции</div>
                        </div>
                        <div class="col-md-6">
                            <TheLabel for="end_date" required>Окончание промо-акции</TheLabel>
                            <TheInput
                                id="end_date"
                                type="text"
                                readonly="readonly"
                                aria-describedby="end_date_help"
                            />
                            <div id="end_date_help" class="form-text">укажите дату окончания акции</div>
                        </div>
                        <div class="col-md-6">
                            <TheLabel
                                for="products"
                                :required="currentPromoType.isForRetail === true"
                            >Ассортимент для акции</TheLabel>
                            <div class="input-group">
                                <input
                                    id="products"
                                    type="text"
                                    class="form-control"
                                    value="Ассортимент добавлен?"
                                    aria-describedby="products_help"
                                    :disabled="!currentPromoType.isForRetail"
                                    readonly
                                >
                                <template v-if="currentPromoType.isForRetail === true">
                                    <span
                                        v-if="state.promo.products.length > 0"
                                        class="input-group-text border-success bg-success text-white px-4"
                                    >Да</span>
                                    <span
                                        v-else
                                        class="input-group-text border-warning bg-warning px-4"
                                    >Нет</span>
                                </template>
                            </div>
                            <div id="products_help" class="form-text">только для скидочных акций</div>
                        </div>
                        <div class="col-md-6">
                            <TheLabel
                                for="sellers"
                                :required="currentPromoType.type === 'SALES_PEOPLE_BOOST'"
                            >Команда ТП</TheLabel>
                            <div class="input-group">
                                <input
                                    id="sellers"
                                    type="text"
                                    class="form-control"
                                    value="Команда добавлена?"
                                    aria-describedby="sellers_help"
                                    :disabled="currentPromoType.type !== 'SALES_PEOPLE_BOOST'"
                                    readonly
                                >
                                <template v-if="currentPromoType.type === 'SALES_PEOPLE_BOOST'">
                                    <span
                                        v-if="state.promo.sellers.length > 0"
                                        class="input-group-text border-success bg-success text-white px-4"
                                    >Да</span>
                                    <span
                                        v-else
                                        class="input-group-text border-warning bg-warning px-4"
                                    >Нет</span>
                                </template>
                            </div>
                            <div id="sellers_help" class="form-text">только для мотивации ТП</div>
                        </div>
                        <div class="col-12">
                            <TheLabel for="comments">Механика промо-акции</TheLabel>
                            <textarea
                                id="comments"
                                v-model="state.promo.comments"
                                class="form-control"
                                style="height: 100px;"
                            ></textarea>
                        </div>
                    </div>
                </div>
                <pre>{{ state.promo }}</pre>
                <div class="card-footer">
                    <TheButton
                        @click="savePromo"
                        :class="[
                            'btn-primary',
                            { 'btn-cursor-not-allowed' : !isFormValid() }
                        ]"
                        :disabled="spinnerStore.isButtonDisabled || !isFormValid()"
                        :loading="spinnerStore.isButtonDisabled"
                    >Сохранить
                    </TheButton>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <Suspense v-if="currentPromoType.type === 'DISCOUNT'">
                <template #default>
                    <TheDiscount
                        :title="currentPromoType.title"
                        :customer-name="state.customerName"
                        :retailer-name="state.retailerName"
                        @add-products-to-promo="addProductHandler"
                    />
                </template>
                <template #fallback>
                    <p>Loading...</p>
                </template>
            </Suspense>
            <Suspense v-if="currentPromoType.type === 'SALES_PEOPLE_BOOST'">
                <template #default>
                    <SalesPeopleBoost
                        :title="currentPromoType.title"
                        :customer-id="state.promo.customerId"
                        :customer-name="state.customerName"
                        @add-sellers-to-promo="addSellersHandler"
                    />
                </template>
                <template #fallback>
                    <p>Loading...</p>
                </template>
            </Suspense>
            <Suspense v-if="currentPromoType.type === 'GIFT_FOR_PURCHASE'">
                <template #default>
                    <GiftForPurchase
                        :title="currentPromoType.title"
                    />
                </template>
                <template #fallback>
                    <p>Loading...</p>
                </template>
            </Suspense>
            <Suspense v-if="currentPromoType.type === 'RETAILERS_BOOST'">
                <template #default>
                    <RetailersBoost
                        :title="currentPromoType.title"
                    />
                </template>
                <template #fallback>
                    <p>Loading...</p>
                </template>
            </Suspense>
            <component
                :is="CoverageIncrease"
                v-if="currentPromoType.type === 'COVERAGE_INCREASE'"
                :title="currentPromoType.title"
            ></component>
            <component
                :is="TheInOut"
                v-if="currentPromoType.type === 'IN_OUT'"
                :title="currentPromoType.title"
            ></component>
            <div v-if="currentPromoType.type === ''" class="alert alert-warning  alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Детали промо-акции</h4>
                <p>Здесь будут выведены поля для ввода ассортимента, команды торговых представителей и др. в зависимости от выбранного вида промо-акции.</p>
                <hr>
                <p>Выберите вид промо-акции в выпадающем списке в панели общих настроек промо-акции.</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, defineAsyncComponent, onMounted, reactive, watch } from 'vue';
import { useAuthStore } from '@/stores/auth.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useRouter } from 'vue-router';
import { useHttpService } from '@/use/useHttpService.js';
import { formatDateToISO } from '@/helpers/formatters.js';
import { useDatepicker } from 'vue-air-datepicker';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import { FOUR_WEEKS_AHEAD, MANAGER_URLS, PROMO_TYPES, TWO_WEEKS_AHEAD } from '@/helpers/constants.js';
import Alert from '@/components/Alert.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import TheButton from '@/components/core/TheButton.vue';
import TheInput from '@/components/form/TheInput.vue';
import localeRu from 'air-datepicker/locale/ru';
import CoverageIncrease from '@/pages/Promo/CoverageIncrease.vue';
import TheInOut from '@/pages/Promo/TheInOut.vue';

const { get, post } = useHttpService();
const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const router = useRouter();
const authUser = useAuthStore().getUser;
const arrayHandlers = useArrayHandlers();

useDatepicker('#start_date', {
    locale: localeRu,
    startDate: TWO_WEEKS_AHEAD,
    onSelect: ({ date, datepicker }) => {
        state.promo.startDate = formatDateToISO(date);
        datepicker.hide();
    },
});

useDatepicker('#end_date', {
    locale: localeRu,
    startDate: FOUR_WEEKS_AHEAD,
    onSelect: ({ date, datepicker }) => {
        state.promo.endDate = formatDateToISO(date);
        datepicker.hide();
    },
});

const TheDiscount = defineAsyncComponent({
    loader: () => import('@/pages/Promo/TheDiscount.vue'),
});

const SalesPeopleBoost = defineAsyncComponent({
    loader: () => import('@/pages/Promo/SalesPeopleBoost.vue'),
});

const GiftForPurchase = defineAsyncComponent(() =>
    import('@/pages/Promo/GiftForPurchase.vue'),
);

const RetailersBoost = defineAsyncComponent({
    loader: () => import('@/pages/Promo/RetailersBoost.vue'),
});

const initialFormData = () => ({
    promoType: '',
    promoForRetail: false,
    discount: null,
    userId: authUser.id,
    channelId: '',
    customerId: '',
    retailerId: '',
    regionId: '',
    cityId: '',
    startDate: '',
    endDate: '',
    comments: '',
    totalSalesBefore: 0,
    totalSalesPlan: 0,
    totalBudgetPlan: 0,
    products: [],
    sellers: [],
});

const state = reactive({
    customers: [],
    retailers: [],
    cities: [],
    channels: [],
    customerName: '',
    retailerName: '',
    promo: initialFormData(),
});

let currentPromoType = reactive({
    isForRetail: false,
    type: '',
    title: '',
    code: '',
});

onMounted(async () => {
    state.promo = initialFormData();
    await getCustomers();
});

const getChannels = async (promoType) => {
    const { data } = await get(MANAGER_URLS.CHANNEL);
    state.channels = data.channels.filter(channel => channel.isForRetail === promoType.isForRetail);
};

const getCustomers = async () => {
    const { data } = await get(MANAGER_URLS.CUSTOMER, {
        params: {
            region: true,
            city: true,
            user: true,
            retailers: true,
        },
    });
    state.customers = data;
};

watch(
    () => state.promo.promoType,
    async (newValue) => {
        const promoType = newValue;
        currentPromoType = PROMO_TYPES.find(pt => pt.type === promoType);

        state.promo.promoForRetail = currentPromoType.isForRetail;

        state.promo.discount = null;
        state.promo.channelId = '';
        state.promo.customerId = '';
        state.promo.retailerId = '';
        state.promo.regionId = '';
        state.promo.cityId = '';
        state.promo.products = [];
        state.promo.sellers = [];

        await getChannels(currentPromoType);
    },
);

watch(
    () => state.promo.customerId,
    (newValue) => {
        if ( newValue !== '' ) {
            const customer = state.customers.find(customer => +customer.id === +newValue);

            state.promo.regionId = customer.region.id;
            state.promo.cityId = customer.city.id;
            state.promo.products = [];
            state.promo.sellers = [];

            state.customerName = customer.name;

            state.promo.retailerId = '';
            state.customers.map(customer => {
                if ( +customer.id === +newValue ) {
                    state.retailers = customer.retailers;
                }
            });
        } else {
            state.customerName = newValue.toString();
        }
    },
);

watch(
    () => state.promo.retailerId,
    (newValue) => {
        state.retailerName = newValue !== ''
            ? state.retailerName = state.retailers.find(retailer => +retailer.id === +newValue).name
            : newValue.toString();
    },
);

const addProductHandler = (products, salesBefore, salesPlan, budgetPlan) => {
    state.promo.products = products;
    state.promo.totalSalesBefore = salesBefore;
    state.promo.totalSalesPlan = salesPlan;
    state.promo.totalBudgetPlan = budgetPlan;
};

const addSellersHandler = (sellers, salesBefore, salesPlan, budgetPlan) => {
    state.promo.sellers = sellers.filter(item => (item.salesBefore !== 0 || item.salesBefore !== null) && item.salesPlan !== 0);
    state.promo.totalSalesBefore = salesBefore;
    state.promo.totalSalesPlan = salesPlan;
    state.promo.totalBudgetPlan = budgetPlan;
};

const isFormValid = () => {
    return (currentPromoType.type === 'DISCOUNT' && state.promo.products.length > 0)
        || (currentPromoType.type === 'SALES_PEOPLE_BOOST' && state.promo.sellers.length > 0);
};

const savePromo = async () => {
    const response = await post(MANAGER_URLS.PROMO, state.promo);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        await router.push({
            name: 'Manager.Promo.Index'
        });
    }
};

const sortedCustomers = computed(() => {
    return arrayHandlers.sortArrayByStringColumn(state.customers, 'name');
});

const regions = computed(() => {
    return arrayHandlers.getUniqueObjectsFromArray(
        sortedCustomers.value.map(customer => customer.region)
    );
});

const cities = computed(() => {
    return arrayHandlers.getUniqueObjectsFromArray(
        sortedCustomers.value.map(customer => customer.city)
    );
});
</script>
