<template>
    <div>
        <div class="card">
            <div class="card-header bg-success text-white">{{ props.title }}</div>
            <div class="card-body mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Итоговый бюджет на промо-акцию:</h4>
                    <h4 class="text-primary fw-bold mb-0">{{ isNaN(totalBudgetPlan) ? '0' : formatNumber(totalBudgetPlan) }} руб.</h4>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-0 alert border-primary fade show" role="alert">
                            <h5 class="mb-0">Дистрибутор: <span class="fw-bold text-primary">{{ props.customerName }}</span></h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-0 alert border-primary fade show" role="alert">
                            <h5 class="mb-0">Сеть: <span class="fw-bold text-primary">{{ props.retailerName }}</span></h5>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><span class="fw-bold text-primary">Шаг 1.</span> Расчёт стоимости доставки 1 кг продукции:</h6>
                        <h5 class="text-secondary fw-bold mb-0">{{ formatNumberWithFractions(transportRatePerKilo) }} руб/кг</h5>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <TheLabel
                            for="transport_rate"
                        >Стоимость доставки, вкл. НДС:&nbsp;&nbsp;<span class="fw-bold text-primary fs-5">
                            {{ formatNumber(state.transportRate) }}&nbsp;руб.
                        </span>
                        </TheLabel>
                        <InputRange
                            id="transport_rate"
                            v-model="state.transportRate"
                            :max="200000"
                            :min="20000"
                            :step="1000"
                        />
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <TheLabel
                            for="order_weight"
                        >Вес заказа:&nbsp;&nbsp;<span class="fw-bold text-primary fs-5">
                            {{ formatNumber(state.orderWeight) }}&nbsp;кг
                        </span>
                        </TheLabel>
                        <InputRange
                            id="order_weight"
                            v-model="state.orderWeight"
                            :max="25000"
                            :min="5000"
                            :step="500"
                        />
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><span class="fw-bold text-primary">Шаг 2.</span> Ассортимент для промо-акции:</h6>
                    <TheButton
                        @click="modals.addModalPopUp = true; state.form = initialFormData(); state.products = []; state.product = initialProductData();"
                        class="btn-success"
                        :disabled="state.categories.length === 0"
                    >Добавить</TheButton>
                </div>
                <hr>
                <div v-if="state.addedProducts.length > 0" class="row row-cols-xl-2 row-cols-lg-2 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3">
                    <DiscountProductCard
                        v-for="(product, index) in state.addedProducts"
                        :key="product.id"
                        :index="index"
                        :product="product"
                        @remove-product="removeProduct"
                    />
                </div>
            </div>
        </div>
        <TheModal
            v-if="modals.addModalPopUp"
            v-model="modals.addModalPopUp"
            id="addModalPopUp"
            :custom-classes="['modal-lg']"
        >
            <template #title>
                Добавление ассортимента для промо-акции
            </template>
            <template #body>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <TheLabel for="category_id" required>Группа товара</TheLabel>
                        <select
                            v-model="state.form.categoryId"
                            @change="displayProducts"
                            id="category_id"
                            class="form-select"
                        >
                            <option disabled selected value="">-- Выберите группу товара --</option>
                            <option
                                v-for="category in state.categories"
                                :key="category.id"
                                :value="category.id"
                            >{{ category.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <TheLabel for="product_id" required>Ассортимент</TheLabel>
                        <select
                            v-model="state.form.productId"
                            @change="displayOneProduct"
                            id="product_id"
                            class="form-select"
                        >
                            <option disabled selected value="">-- Выберите акционный продукт --</option>
                            <option
                                v-for="product in state.products"
                                :key="product.id"
                                :value="product.id"
                            >{{ product.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row g-3 mb-0">
                    <div class="col-12">
                        <TheLabel
                            for="discount"
                            class="mb-0"
                        >Скидка:&nbsp;&nbsp;<span class="fw-bold text-primary fs-5">
                            {{ state.form.discount }}&#8239;%
                        </span>
                        </TheLabel>
                        <InputRange
                            id="discount"
                            v-model="state.form.discount"
                            :min="0"
                            :max="50"
                            :step="1"
                            :disabled="!state.form.productId"
                        />
                    </div>
                </div>
                <p class="mb-2 fs-6 text-primary text-end"><span
                    class="border-bottom border-primary"
                    style="cursor: pointer;"
                    @click="displayCalcRef = !displayCalcRef"
                >{{ displayCalcRef ? 'Скрыть расчёт' : 'Показать расчёт'  }}</span></p>
                <div v-show="displayCalcRef === true">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <TheLabel for="product_price">Цена прайса дистрибьютора</TheLabel>
                            <div class="input-group">
                                <TheInput
                                    id="product_price"
                                    :model-value="formatNumberWithFractions(state.product.price)"
                                    class="text-center bg-warning-light"
                                    :tabindex="-1"
                                />
                                <span class="input-group-text">руб.</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <TheLabel for="product_price_no_vat">Цена прайса дистрибьютора без НДС</TheLabel>
                            <div class="input-group">
                                <TheInput
                                    id="product_price_no_vat"
                                    :model-value="formatNumberWithFractions(state.product.priceNoVAT)"
                                    class="text-center bg-warning-light"
                                    :tabindex="-1"
                                />
                                <span class="input-group-text">руб.</span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <TheLabel for="customer_price">Акционная цена</TheLabel>
                            <div class="input-group">
                                <TheInput
                                    id="customer_price"
                                    :model-value="formatNumberWithFractions(state.form.promoPrice)"
                                    class="text-center bg-warning-light"
                                    readonly="readonly"
                                    :tabindex="-1"
                                />
                                <span class="input-group-text">&#8381;</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <TheLabel for="gross_profit">Валовая прибыль (без НДС)</TheLabel>
                            <div class="input-group">
                                <TheInput
                                    id="gross_profit"
                                    :model-value="formatNumberWithFractions(calcGrossProfit)"
                                    class="text-center bg-warning-light"
                                    readonly="readonly"
                                    :tabindex="-1"
                                />
                                <span class="input-group-text">&#8381;</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <TheLabel for="transport_rate_per_unit">Транспорт, руб/шт.</TheLabel>
                            <div class="input-group">
                                <TheInput
                                    id="transport_rate_per_unit"
                                    :model-value="formatNumberWithFractions(calcTransportRatePerUnit)"
                                    class="text-center bg-warning-light"
                                    readonly="readonly"
                                    :tabindex="-1"
                                />
                                <span class="input-group-text">&#8381;</span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <TheLabel for="office_expenses">Офис, руб/шт.</TheLabel>
                            <div class="input-group">
                                <TheInput
                                    id="office_expenses"
                                    :model-value="formatNumberWithFractions(calcOfficeExpenses)"
                                    class="text-center bg-warning-light"
                                    readonly="readonly"
                                    aria-describedby="office_expenses_help"
                                    :tabindex="-1"
                                />
                                <span class="input-group-text">&#8381;</span>
                            </div>
                            <div id="office_expenses_help" class="form-text">акционная цена * 7.5%</div>
                        </div>
                        <div class="col-md-4">
                            <TheLabel for="marketing_expenses">Маркетинг, руб/шт.</TheLabel>
                            <div class="input-group">
                                <TheInput
                                    id="marketing_expenses"
                                    :model-value="formatNumberWithFractions(calcMarketingExpenses)"
                                    class="text-center bg-warning-light"
                                    readonly="readonly"
                                    aria-describedby="marketing_expenses_help"
                                    :tabindex="-1"
                                />
                                <span class="input-group-text">&#8381;</span>
                            </div>
                            <div id="marketing_expenses_help" class="form-text">акционная цена * 5%</div>
                        </div>
                        <div class="col-md-4">
                            <TheLabel for="profit_per_product">Прибыль на {{ formatNumber(state.form.salesPlan) }} шт.</TheLabel>
                            <div class="input-group">
                                <TheInput
                                    id="profit_per_product"
                                    :model-value="formatNumberWithFractions(state.form.profitPerProduct)"
                                    class="text-center bg-warning-light"
                                    readonly="readonly"
                                    :tabindex="-1"
                                />
                                <span class="input-group-text">&#8381;</span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <TheLabel for="profit_per_unit">Прибыль на 1 шт.</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="profit_per_unit"
                                :model-value="formatNumberWithFractions(state.form.profitPerUnit)"
                                class="text-center bg-warning-light"
                                readonly="readonly"
                                aria-describedby="profit_per_unit_help"
                                :tabindex="-1"
                            />
                            <span class="input-group-text">руб.</span>
                        </div>
                        <div id="profit_per_unit_help" class="form-text">рассчитывается автоматически</div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="compensation">Компенсация на 1 шт.</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="compensation"
                                :model-value="formatNumberWithFractions(state.form.compensation)"
                                class="text-center bg-warning-light"
                                readonly="readonly"
                                aria-describedby="compensation_help"
                                :tabindex="-1"
                            />
                            <span class="input-group-text">руб.</span>
                        </div>
                        <div id="compensation_help" class="form-text">разница между прайсом и акц. ценой</div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="budget_plan">Бюджет</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="budget_plan"
                                :model-value="formatNumber(state.form.budgetPlan)"
                                class="text-center fw-bold"
                                disabled="disabled"
                                aria-describedby="budget_plan_help"
                            />
                            <span class="input-group-text">руб.</span>
                        </div>
                        <div id="budget_plan_help" class="form-text">компенсация * план продаж</div>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <TheLabel for="sales_before" required>Продажи "До акции"</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="sales_before"
                                v-model="state.form.salesBefore"
                                class="text-center"
                                aria-describedby="sales_before_help"
                                @blur="processInputValue($event.target.value, 'sales_before')"
                                :disabled="!state.form.productId"
                            />
                            <span class="input-group-text">шт.</span>
                        </div>
                        <div id="sales_before_help" class="form-text">если продаж не было, введите 0</div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="sales_plan" required>План продаж "Во время"</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="sales_plan"
                                v-model="state.form.salesPlan"
                                class="text-center"
                                aria-describedby="sales_plan_help"
                                @blur="processInputValue($event.target.value, 'sales_plan')"
                                :disabled="!state.form.productId"
                            />
                            <span class="input-group-text">шт.</span>
                        </div>
                        <div id="sales_plan_help" class="form-text">обязательно к заполнению</div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="surplus_plan">План прироста</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="surplus_plan"
                                :model-value="formatNumber(state.form.surplusPlan)"
                                class="text-center fw-bold"
                                disabled="disabled"
                                aria-describedby="surplus_plan_help"
                            />
                            <span class="input-group-text">%</span>
                        </div>
                        <div id="surplus_plan_help" class="form-text">рассчитывается автоматически</div>
                    </div>
                </div>
                <hr>
                <div class="row g-3">
                    <div class="col-md-4 offset-md-2">
                        <TheLabel for="revenue_plan">Выручка</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="revenue_plan"
                                :model-value="formatNumber(state.form.revenuePlan)"
                                class="text-center bg-warning-light"
                                readonly="readonly"
                                :tabindex="-1"
                            />
                            <span class="input-group-text">руб.</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="net_profit_standard">Норматив чистой прибыли</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="net_profit_standard"
                                :model-value="formatNumber(state.form.netProfit)"
                                :class="['text-center fw-bold', netProfitClass]"
                                readonly="readonly"
                                :tabindex="-1"
                            />
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
            </template>
            <template #footer>
                <TheButton
                    @click="addProduct"
                    class="btn-success w-25"
                    :disabled="!isFormValid"
                >Добавить</TheButton>
            </template>
        </TheModal>
    </div>
</template>

<script setup>
import { computed, reactive, ref, watch } from 'vue';
import { useHttpService } from '@/use/useHttpService.js';
import {
    convertInputStringToNumber,
    formatNumber,
    formatNumberWithFractions,
    processInputValue,
} from '@/helpers/formatters.js';
import TheModal from '@/components/TheModal.vue';
import TheButton from '@/components/core/TheButton.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import TheInput from '@/components/form/TheInput.vue';
import { MANAGER_URLS, MARKETING_EXPENSES, OFFICE_EXPENSES, VAT_RATE } from '@/helpers/constants.js';
import DiscountProductCard from '@/pages/Promo/DiscountProductCard.vue';
import { useCalculations } from '@/use/useCalculations.js';
import InputRange from '@/components/form/InputRange.vue';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';

const { get } = useHttpService();
const { calcDifferencePercentage, calcBudget } = useCalculations();
const arrayHandlers = useArrayHandlers();

const props = defineProps({
    title: {
        type: String,
        required: true,
        default: 'Title is required',
    },
    customerId: {
        type: Number,
        default: 0,
    },
    customerName: {
        type: String,
        default: '',
    },
    retailerName: {
        type: String,
        default: '',
    },
});

const emit = defineEmits([
    'addProductsToPromo',
]);

const initialFormData = () => ({
    categoryId: '',
    productId: '',
    discount: 0,
    promoPrice: 0,
    salesBefore: 0,
    salesPlan: 0,
    surplusPlan: 0,
    profitPerUnit: 0,
    profitPerProduct: 0,
    compensation: 0,
    budgetPlan: 0,
    netProfit: 0,
    revenuePlan: 0,
});

const initialProductData = () => ({
    id: '',
    name: '',
    weight: 0,
    price: 0, // отпускная цена дистрибьютора из БД customer_product
    priceNoVAT: 0, // price / 1.1
    initialPrice: 0, // себестоимость из БД products
});

const state = reactive({
    transportRate: 50000,
    orderWeight: 15000,
    categories: [],
    products: [],
    addedProducts: [],
    addedProductsIds: [],
    form: initialFormData(),
    product: initialProductData(),
});

const modals = reactive({
    addModalPopUp: false,
});

const displayCalcRef = ref(true);

const displayProducts = () => {
    state.categories.map(category => {
        if ( +category.id === +state.form.categoryId ) {
            state.products = category.products;
        }
    });
    state.products = state.products.filter(pr => !state.addedProductsIds.includes(pr.id));
};

const displayOneProduct = () => {
    state.product = initialProductData();

    const catIdx = state.categories.findIndex(c => +c.id === +state.form.categoryId);
    state.product = state.categories[catIdx].products.find(p => p.id === +state.form.productId);

    state.form.discount = 20;
    state.form.salesBefore = 0;
    state.form.salesPlan = 0;

    calcPromoPrice(state.form.discount);
    calcProfitPerUnit();
    calcProfitPerProduct();
    calcRevenue();
    calcNetProfit();
    calcCompensation();
};

const addProduct = () => {
    state.addedProducts.push({
        categoryId: state.form.categoryId,
        productId: state.form.productId,
        categoryName: getCategoryName(),
        productName: getProductName(),
        salesBefore: state.form.salesBefore,
        salesPlan: state.form.salesPlan,
        surplusPlan: state.form.surplusPlan,
        budgetPlan: state.form.budgetPlan,
        compensation: state.form.compensation,
        profitPerUnit: state.form.profitPerUnit,
        discount: state.form.discount,
        promoPrice: state.form.promoPrice,
        profitPerProduct: state.form.profitPerProduct,
        netProfit: state.form.netProfit,
        revenuePlan: state.form.revenuePlan,
    });
    state.addedProductsIds.push(+state.form.productId);
    emit('addProductsToPromo',
        state.addedProducts,
        totalSalesBefore.value,
        totalSalesPlan.value,
        totalBudgetPlan.value,
    );
    state.products = [];
    modals.addModalPopUp = false;
};

const removeProduct = (index) => {
    state.addedProducts.splice(index, 1);
    state.addedProductsIds.splice(index, 1);
    emit('addProductsToPromo',
        state.addedProducts,
        totalSalesBefore.value,
        totalSalesPlan.value,
        totalBudgetPlan.value,
    );
};

const getCategoryName = () => {
  const catIdx = state.categories.findIndex(c => +c.id === +state.form.categoryId);
  return state.categories[catIdx].name;
};

const getProductName = () => {
  const catIdx = state.categories.findIndex(c => +c.id === +state.form.categoryId);
  const prodIdx = state.categories[catIdx].products.findIndex(p => p.id === +state.form.productId);
  return state.categories[catIdx].products[prodIdx].name;
};

const isFormValid = computed(() => {
    let valid = true;

    const excludedKeys = [
        'salesBefore',
        'surplusPlan',
        'compensation',
        'budgetPlan',
        'profitPerUnit',
        'netProfit',
    ];

    for (let [key, value] of Object.entries(state.form)) {
        if ( excludedKeys.includes(key) ) {
            continue;
        }
        if ( !value ) {
            valid = false;
            break;
        }
    }

    return valid;
});

const totalSalesBefore = computed(() => {
    return state.addedProducts.reduce((acc, pr) => {
        return acc + parseInt(pr.salesBefore);
    }, 0);
});

const totalSalesPlan = computed(() => {
    return state.addedProducts.reduce((acc, pr) => {
        return acc + parseInt(pr.salesPlan);
    }, 0);
});

const totalBudgetPlan = computed(() => {
   return state.addedProducts.reduce((acc, pr) => {
       return acc + parseInt(pr.budgetPlan);
   }, 0);
});

const transportRatePerKilo = computed(() => {
    return (state.transportRate / VAT_RATE) / state.orderWeight;
});

const calcTransportRatePerUnit = computed(() => {
    return transportRatePerKilo.value * (state.product.weight / 1000);
});

const calcOfficeExpenses = computed(() => {
    return state.form.promoPrice * OFFICE_EXPENSES;
});

const calcMarketingExpenses = computed(() => {
    return state.form.promoPrice * MARKETING_EXPENSES;
});

const calcGrossProfit = computed(() => {
    return state.form.promoPrice - state.product.initialPrice;
});

const netProfitClass = computed(() => {
    return state.form.netProfit >= 20
        ? 'bg-success-light text-success'
        : 'bg-danger-light text-danger';
});

watch(
    () => props.customerId,
    async (newValue) => {
        if ( newValue !== 0 ) {
            state.categories = [];
            await fetchCustomerProducts(newValue);
        }
    },
);

watch(() => state.form.discount,
    (newValue) => {
        calcPromoPrice(newValue);
        calcProfitPerUnit();
        calcProfitPerProduct();
        calcRevenue();
        calcNetProfit();
        calcCompensation();
    },
);

watch(() => state.form.salesBefore,
    () => calcSurplusPlan(),
);

watch(() => state.form.salesPlan,
    () => {
        calcProfitPerProduct();
        calcSurplusPlan();
        calcBudgetPlan();
        calcRevenue();
    },
);

watch(() => state.form.compensation,
    () => {
        calcBudgetPlan();
    },
);

const fetchCustomerProducts = async (customerId) => {
    const { status, data } = await get(`${ MANAGER_URLS.CUSTOMER }/${ customerId }${ MANAGER_URLS.PRODUCT }`, {
        params: {
            category: true,
            product: true,
            is_listed: true,
        },
    });
    if ( status === 'success' ) {
        data.products.map(item => {
            const idx = state.categories.findIndex(c => c.id === item.categoryId);
            if ( idx === -1 ) {
                state.categories.push({
                    id: item.categoryId,
                    name: item.categoryName,
                    products: [{
                        id: item.productId,
                        name: item.productName,
                        weight: item.productWeight,
                        price: item.customerPrice,
                        priceNoVAT: item.customerPriceNoVAT,
                        initialPrice: item.productInitialPrice,
                        marketingExpenses: item.marketingExpenses,
                    }],
                });
            } else {
                state.categories[idx].products = [
                    ...state.categories[idx].products,
                    {
                        id: item.productId,
                        name: item.productName,
                        weight: item.productWeight,
                        price: item.customerPrice,
                        priceNoVAT: item.customerPriceNoVAT,
                        initialPrice: item.productInitialPrice,
                        marketingExpenses: item.marketingExpenses,
                    }
                ];
                state.categories[idx].products = arrayHandlers.sortArrayByStringColumn(state.categories[idx].products, 'name');
            }
        });
    }
};

const calcProfitPerUnit = () => {
    state.form.profitPerUnit = calcGrossProfit.value - calcTransportRatePerUnit.value - calcOfficeExpenses.value - calcMarketingExpenses.value;
};
const calcPromoPrice = (discountPercent) => {
    const discount = 1 - discountPercent / 100;
    state.form.promoPrice = state.product.priceNoVAT * discount;
};

const calcRevenue = () => {
    state.form.revenuePlan = Math.round(state.form.salesPlan * state.form.promoPrice);
};

const calcNetProfit = () => {
    state.form.netProfit = Math.round((state.form.profitPerUnit / state.form.promoPrice) * 100);
};

const calcProfitPerProduct = () => {
    state.form.profitPerProduct = convertInputStringToNumber(state.form.salesPlan) * state.form.profitPerUnit;
};

const calcCompensation = () => {
    state.form.compensation = state.product.priceNoVAT - state.form.promoPrice;
};

function calcSurplusPlan() {
    state.form.surplusPlan = calcDifferencePercentage(state.form.salesBefore, state.form.salesPlan);
}

function calcBudgetPlan() {
    state.form.budgetPlan = calcBudget(state.form.salesPlan, state.form.compensation);
}
</script>
