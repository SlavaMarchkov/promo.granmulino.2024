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
                        <h5 class="text-secondary fw-bold mb-0">{{ formatNumberWithFractions(transportRatePerKilo) }} руб.</h5>
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
                        @click="modals.addModalPopUp = true; state.form = initialFormData(); state.products = [];"
                        class="btn-success"
                    >Добавить</TheButton>
                </div>
                <hr>
                <div v-if="state.addedProducts.length > 0" class="row row-cols-xl-3 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3">
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
                <div class="row g-3">
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
                            id="product_id"
                            class="form-select"
                        >
                            <option disabled selected value="">-- Выберите SKU для промо-акции --</option>
                            <option
                                v-for="product in state.products"
                                :key="product.id"
                                :value="product.id"
                            >{{ product.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="sales_before" required>Продажи "До акции"</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="sales_before"
                                v-model="state.form.salesBefore"
                                type="text"
                                class="text-end"
                                aria-describedby="sales_before_help"
                                @blur="processInputValue($event.target.value, 'sales_before')"
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
                                type="text"
                                class="text-end"
                                @blur="processInputValue($event.target.value, 'sales_plan')"
                            />
                            <span class="input-group-text">шт.</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="surplus_plan" required>План прироста</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="surplus_plan"
                                v-model="state.form.surplusPlan"
                                type="text"
                                class="text-end fw-bold"
                                disabled="disabled"
                                aria-describedby="surplus_plan_help"
                            />
                            <span class="input-group-text">%</span>
                        </div>
                        <div id="surplus_plan_help" class="form-text">рассчитывается автоматически</div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="profit_per_unit" required>Прибыль на 1 шт.</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="profit_per_unit"
                                v-model="state.form.profitPerUnit"
                                type="number"
                                min="0"
                                step="0.01"
                                aria-describedby="profit_per_unit_help"
                            />
                            <span class="input-group-text">руб.</span>
                        </div>
                        <div id="profit_per_unit_help" class="form-text">берётся из P&L</div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="compensation" required>Компенсация на 1 шт.</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="compensation"
                                v-model="state.form.compensation"
                                type="number"
                                min="0"
                                step="0.01"
                                aria-describedby="compensation_help"
                            />
                            <span class="input-group-text">руб.</span>
                        </div>
                        <div id="compensation_help" class="form-text">если компенсации нет, введите 0</div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="budget_plan" required>Бюджет</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="budget_plan"
                                v-model="state.form.budgetPlan"
                                class="text-end fw-bold"
                                type="text"
                                disabled="disabled"
                                aria-describedby="budget_plan_help"
                            />
                            <span class="input-group-text">руб.</span>
                        </div>
                        <div id="budget_plan_help" class="form-text">компенсация * план продаж</div>
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
import { computed, onMounted, reactive, watch } from 'vue';
import { useHttpService } from '@/use/useHttpService.js';
import { formatNumber, formatNumberWithFractions, processInputValue } from '@/helpers/formatters.js';
import TheModal from '@/components/TheModal.vue';
import TheButton from '@/components/core/TheButton.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import TheInput from '@/components/form/TheInput.vue';
import { MANAGER_URLS, VAT_RATE } from '@/helpers/constants.js';
import DiscountProductCard from '@/pages/Promo/DiscountProductCard.vue';
import { useCalculations } from '@/use/useCalculations.js';
import InputRange from '@/components/form/InputRange.vue';

const { get } = useHttpService();
const { calcDifferencePercentage, calcBudget } = useCalculations();

const props = defineProps({
    title: {
        type: String,
        required: true,
        default: 'Title is required',
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
    salesBefore: '',
    salesPlan: '',
    surplusPlan: 0,
    profitPerUnit: '',
    compensation: '',
    budgetPlan: 0,
});

const state = reactive({
    transportRate: 50000,
    orderWeight: 15000,
    categories: [],
    products: [],
    addedProducts: [],
    addedProductsIds: [],
    form: initialFormData(),
});

const modals = reactive({
    addModalPopUp: false,
});

onMounted(async () => {
    await getCategories();
});

const getCategories = async () => {
    const { data } = await get(MANAGER_URLS.CATEGORY);
    state.categories = data.categories;
};

const displayProducts = () => {
    state.categories.map(category => {
        if ( +category.id === +state.form.categoryId ) {
            state.products = category.products;
        }
    });
    state.products = state.products.filter(pr => !state.addedProductsIds.includes(pr.id));
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
        'budgetPlan'
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

watch(() => state.form.salesBefore,
    () => calcSurplusPlan(),
);

watch(() => state.form.salesPlan,
    () => {
        calcSurplusPlan();
        calcBudgetPlan();
    }
);

watch(() => state.form.compensation,
    () => {
        calcBudgetPlan();
    }
);

function calcSurplusPlan() {
    const result = calcDifferencePercentage(
        state.form.salesBefore.toString(),
        state.form.salesPlan.toString());
    state.form.surplusPlan = !isNaN(result) ? result : 0;
}

function calcBudgetPlan() {
    const result = calcBudget(state.form.salesPlan, state.form.compensation);
    state.form.budgetPlan = !isNaN(result) ? result : 0;
}
</script>
