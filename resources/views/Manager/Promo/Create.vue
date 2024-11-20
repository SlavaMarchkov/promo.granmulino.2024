<template>
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header bg-primary text-white">Укажите общие данные промо-акции</div>
                <div class="card-body mt-3">
                    <Alert/>
                    <pre>
                        {{ state.promo }}
                    </pre>
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
                            <TheLabel for="discount" :required="currentPromoType === 'DISCOUNT'">Величина скидки
                            </TheLabel>
                            <div class="input-group">
                                <TheInput
                                    id="discount"
                                    v-model="state.promo.discount"
                                    type="number"
                                    min="5"
                                    step="1"
                                    max="50"
                                    :disabled="currentPromoType !== 'DISCOUNT'"
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
                            <TheLabel for="channel_id" required>Канал продаж</TheLabel>
                            <select
                                v-model="state.promo.channelId"
                                id="channel_id"
                                class="form-select"
                            >
                                <option disabled selected value="">- Выберите канал продаж -</option>
                                <option
                                    v-for="channel in filteredChannels"
                                    :key="channel.id"
                                    :value="channel.id"
                                >{{ channel.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <TheLabel for="customer_id" required>Дистрибутор</TheLabel>
                            <select
                                v-model="state.promo.customerId"
                                @change="getRetailersForCustomer"
                                id="customer_id"
                                class="form-select"
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
                            <TheLabel for="retailer_id" :required="state.retailers.length > 0">Торговая сеть</TheLabel>
                            <select
                                v-model="state.promo.retailerId"
                                id="retailer_id"
                                class="form-select"
                                :disabled="state.retailers.length === 0"
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
                                @change="getCitiesForRegion"
                                id="region_id"
                                class="form-select"
                            >
                                <option disabled selected value="">- Выберите регион -</option>
                                <option
                                    v-for="region in getRegions"
                                    :key="region.id"
                                    :value="region.id"
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
                            >
                                <option disabled selected value="">- Выберите город -</option>
                                <option
                                    v-for="city in state.cities"
                                    :key="city.id"
                                    :value="city.id"
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
                            <div class="input-group">
                                <input
                                    id="products"
                                    type="text"
                                    class="form-control"
                                    value="Ассортимент добавлен:"
                                    aria-describedby="products_help"
                                    readonly
                                >
                                <span
                                    v-if="state.promo.products.length > 0"
                                    class="input-group-text border-success bg-success text-white"
                                >Да</span>
                                <span
                                    v-else
                                    class="input-group-text border-danger bg-danger text-white px-4"
                                >Нет</span>
                            </div>
                            <div id="products_help" class="form-text">только для скидочных акций</div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input
                                    id="sellers"
                                    type="text"
                                    class="form-control"
                                    value="Команда добавлена:"
                                    aria-describedby="sellers_help"
                                    readonly
                                >
                                <span
                                    v-if="state.promo.sellers.length > 0"
                                    class="input-group-text border-success bg-success text-white"
                                >Да</span>
                                <span
                                    v-else
                                    class="input-group-text border-danger bg-danger text-white px-4"
                                >Нет</span>
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
                <div class="card-footer">
                    <Button
                        @click="savePromo"
                        type="button"
                        class="btn-primary w-25"
                    >
                        Сохранить
                    </Button>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <TheDiscount
                v-if="currentPromoType.type === 'DISCOUNT'"
                :title="currentPromoType.title"
                @add-product-to-promo="addProductHandler"
                @remove-product-from-promo="removeProductHandler"
            />
            <SalesPeopleBoost
                v-if="currentPromoType === 'SALES_PEOPLE_BOOST' && state.promo.customerId"
                :sellers="state.customerSellers"
                :customer-id="+state.promo.customerId"
                @add-sellers-to-promo="addSellersHandler"
            />
            <GiftForPurchase
                v-if="currentPromoType === 'GIFT_FOR_PURCHASE'"
            />
            <RetailersBoost
                v-if="currentPromoType === 'RETAILERS_BOOST'"
            />
            <CoverageIncrease
                v-if="currentPromoType === 'COVERAGE_INCREASE'"
            />
            <TheInOut
                v-if="currentPromoType === 'IN_OUT'"
            />
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, watch } from 'vue';
import { useAuthStore } from '@/stores/auth.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useHttpService } from '@/use/useHttpService.js';
import { formatDateToISO } from '@/helpers/formatters.js';
import { useDatepicker } from 'vue-air-datepicker';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import { MANAGER_URLS, PROMO_TYPES } from '@/helpers/constants.js';
import Alert from '@/components/Alert.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import Button from '@/components/core/Button.vue';
import TheInput from '@/components/form/TheInput.vue';
import localeRu from 'air-datepicker/locale/ru';
import TheDiscount from '@/pages/TheDiscount.vue';
import SalesPeopleBoost from '@/pages/SalesPeopleBoost.vue';
import GiftForPurchase from '@/pages/GiftForPurchase.vue';
import RetailersBoost from '@/pages/RetailersBoost.vue';
import CoverageIncrease from '@/pages/CoverageIncrease.vue';
import TheInOut from '@/pages/TheInOut.vue';

const { get, post } = useHttpService();
const alertStore = useAlertStore();
const authUser = useAuthStore().getUser;
const arrayHandlers = useArrayHandlers();

useDatepicker('#start_date', {
    locale: localeRu,
    onSelect: ({ date, datepicker }) => {
        state.promo.startDate = formatDateToISO(date);
        datepicker.hide();
    },
});

useDatepicker('#end_date', {
    locale: localeRu,
    onSelect: ({ date, datepicker }) => {
        state.promo.endDate = formatDateToISO(date);
        datepicker.hide();
    },
});

const initialFormData = () => ({
    promoType: '',
    discount: null,
    userId: authUser.id,
    regionId: '',
    cityId: '',
    channelId: '',
    customerId: '',
    retailerId: '',
    startDate: '',
    endDate: '',
    comments: '',
    products: [],
    sellers: [],
});

const state = reactive({
    customerSellers: [],
    customers: [],
    retailers: [],
    cities: [],
    channels: [],
    promo: initialFormData(),
});

let currentPromoType = reactive({
    isForRetail: false,
    type: '',
    title: '',
    code: '',
});

onMounted(async () => {
    await getCustomers();
    await getChannels();
});

const getChannels = async () => {
    const { data } = await get(MANAGER_URLS.CHANNEL);
    state.channels = data.channels;
};

const getCustomers = async () => {
    const { data } = await get(MANAGER_URLS.CUSTOMER, {
        params: {
            'region': true,
            'city': true,
            'user': true,
            'retailers': true,
        },
    });
    state.customers = data.customers;
};

const getCustomerSellers = async (customerId) => {
    const { status, data } = await get(`${MANAGER_URLS.CUSTOMER}/${customerId}`, {
        params: {
            'customer_sellers': true,
        },
    });
    if (status === 'success') state.customerSellers = data.customerSellers;
};


// TODO - check after saving
watch(
    () => state.promo.promoType,
    async (newValue) => {
        state.promo.products = [];
        state.promo.sellers = [];
        state.promo.discount = null;
        const promoType = newValue;
        currentPromoType = PROMO_TYPES.find(pt => pt.type === promoType);

        if ( promoType === 'SALES_PEOPLE_BOOST' && state.promo.customerId ) {
            await getCustomerSellers(state.promo.customerId);
        }
    },
);

watch(
    () => state.promo.customerId,
    async (newValue, oldValue) => {
        if ( state.promo.promoType === 'SALES_PEOPLE_BOOST' ) {
            await getCustomerSellers(state.promo.customerId);
        }
        state.promo.retailerId = '';
        state.customers.map((customer) => {
            if ( +customer.id === +newValue ) {
                state.retailers = customer.retailers;
            }
        });
    },
);

const addProductHandler = (product) => {
    state.promo.products.push(product);
};

const removeProductHandler = (index) => {
    state.promo.products.splice(index, 1);
};

const addSellersHandler = (sellers) => {
    state.promo.sellers = sellers;
};

const getCitiesForRegion = () => {
    state.cities = state.customers
        .map(customer => customer.city)
        .filter(city => city.regionId === +state.promo.regionId)
        .reduce((accumulator, current) => {
            if ( accumulator.findIndex(object => object.id === current.id) === -1 ) {
                accumulator.push(current);
            }
            return accumulator;
        }, []);
};

const savePromo = async () => {
    const response = await post(MANAGER_URLS.PROMO, state.promo);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        state.promo = initialFormData();
    }
};

const sortedCustomers = computed(() => {
    return arrayHandlers.sortArrayByStringColumn(state.customers, 'name');
});

const filteredChannels = computed(() => {

});

const getRegions = computed(() => {
    let arr = state.customers
        .map(customer => customer.region)
        .reduce((accumulator, current) => {
            if ( accumulator.findIndex(object => object.id === current.id) === -1 ) {
                accumulator.push(current);
            }
            return accumulator;
        }, []);

    return arrayHandlers.sortArrayByStringColumn(arr, 'name');
});
</script>
