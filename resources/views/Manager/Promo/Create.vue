<template>
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header bg-primary text-white">Укажите общие данные промо-акции</div>
                <div class="card-body mt-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <TheLabel for="promo_id" required>Вид промо-акции</TheLabel>
                            <select
                                v-model="state.promo.promoId"
                                @change="displayPromoType"
                                id="promo_id"
                                class="form-select"
                            >
                                <option disabled selected value="">- Выберите вид промо-акции -</option>
                                <option
                                    v-for="promo in PROMO_TYPES"
                                    :key="promo.id"
                                    :value="promo.id"
                                >{{ promo.title }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <TheLabel for="discount" :required="currentPromoType === 'discount'">Величина скидки
                            </TheLabel>
                            <div class="input-group">
                                <TheInput
                                    id="discount"
                                    v-model="state.promo.discount"
                                    type="number"
                                    min="5"
                                    step="1"
                                    max="50"
                                    :disabled="currentPromoType !== 'discount'"
                                />
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <TheLabel for="region_id" required>Регион</TheLabel>
                            <select
                                v-model="state.promo.regionId"
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
                            <TheLabel for="channel_id" required>Канал продаж</TheLabel>
                            <select
                                v-model="state.promo.channelId"
                                id="channel_id"
                                class="form-select"
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
                v-show="currentPromoType === 'discount'"
                :categories="state.categories"
                @add-product-to-promo="addProductHandler"
                @remove-product-from-promo="removeProductHandler"
            ></TheDiscount>
            <div v-show="currentPromoType === 'sales_people_boost'" class="card">
                <div class="card-header bg-secondary text-white">Мотивация торгового персонала</div>
                <div class="card-body">
                    Участники из команды ТП
                </div>
            </div>
            <div v-show="currentPromoType === 'gift_for_purchase'" class="card">
                <div class="card-header bg-danger-light text-white">Подарок за покупку</div>
                <div class="card-body">
                    Ассортимент для подарков за покупку
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useHttpService } from '@/use/useHttpService.js';
import { formatDateToISO } from '@/helpers/formatters.js';
import { useDatepicker } from 'vue-air-datepicker';
import TheLabel from '@/components/form/TheLabel.vue';
import { MANAGER_URLS, PROMO_TYPES } from '@/helpers/constants.js';
import TheDiscount from '@/pages/TheDiscount.vue';
import Button from '@/components/core/Button.vue';
import TheInput from '@/components/form/TheInput.vue';
import localeRu from 'air-datepicker/locale/ru';

const { get, post } = useHttpService();

useDatepicker('#start_date', {
    locale: localeRu,
    onSelect: ({ date, formattedDate, datepicker }) => {
        state.promo.startDate = formatDateToISO(date);
        datepicker.hide();
    },
});

useDatepicker('#end_date', {
    locale: localeRu,
    onSelect: ({ date, formattedDate, datepicker }) => {
        state.promo.endDate = formatDateToISO(date);
        datepicker.hide();
    },
});

const initialFormData = () => ({
    promoId: '',
    discount: 0,
    regionId: '',
    channelId: '',
    customerId: '',
    retailerId: '',
    startDate: '',
    endDate: '',
    comments: '',
    products: [],
});

const state = reactive({
    categories: [],
    customers: [],
    retailers: [],
    regions: [],
    channels: [],
    promo: initialFormData(),
});

let currentPromoType = ref('');

onMounted(async () => {
    await getCategories();
    await getCustomers();
    await getChannels();
});

const getCategories = async () => {
    const { data } = await get(MANAGER_URLS.CATEGORY, {
        params: {
            'is_active': true,
        },
    });
    state.categories = data.categories;
};

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

const displayPromoType = () => {
    const promoId = +state.promo.promoId;
    currentPromoType.value = PROMO_TYPES.find(pt => pt.id === promoId).value;
};

const addProductHandler = (product) => {
    state.promo.products.push(product);
};

const removeProductHandler = (index) => {
    state.promo.products.splice(index, 1);
};

const getRetailersForCustomer = () => {
    state.customers.map((customer) => {
        if ( +customer.id === +state.promo.customerId ) {
            state.retailers = customer.retailers;
        }
    });
};

const savePromo = async () => {
    const response = await post(MANAGER_URLS.PROMO, state.promo);
    if ( response && response.status === 'success' ) {
        state.promo = initialFormData();
    }
};

const sortedCustomers = computed(() => {
    return state.customers.sort((a, b) => {
        const fa = a.name.toLocaleLowerCase();
        const fb = b.name.toLocaleLowerCase();
        return (fa < fb) ? -1 : (fa > fb) ? 1 : 0;
    });
});

const getRegions = computed(() => {
    return state.customers
        .map(customer => customer.region)
        .reduce((accumulator, current) => {
            if ( accumulator.findIndex(object => object.id === current.id) === -1 ) {
                accumulator.push(current);
            }
            return accumulator;
        }, [])
        .sort((a, b) => {
            const fa = a.name.toLocaleLowerCase();
            const fb = b.name.toLocaleLowerCase();
            return (fa < fb) ? -1 : (fa > fb) ? 1 : 0;
        });
});
</script>
