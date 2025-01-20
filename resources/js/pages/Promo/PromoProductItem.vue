<template>
    <TheCard :header-classes="['bg-pale py-2']">
        <template #header>
            <h5 class="mb-0">{{ props.index + 1 }}. {{ props.product.categoryName }}&nbsp;<span
                class="text-primary fw-bold">|&nbsp;{{ props.product.productName }}</span></h5>
            <h4 class="mb-0"><span class="badge bg-secondary" v-html="formatAsPercent(props.product.discount)"></span></h4>
            <TheButton
                class="btn-warning"
                style="width: 20%;"
                @click="handleBtnClick"
            >Редактировать
            </TheButton>
        </template>
        <template #body>
            <div class="row">
                <div class="col-3">
                    <TheCard class="info-card revenue-card">
                        <template #header>
                            <h5 class="mb-0 card-title p-0">Бюджет</h5>
                            <h5 :class="[ 'mb-0 fw-bold', calcDiffPercentColor(calcBudgetDiffPercent) ]">
                                <span
                                    :class="['bi', calcBudgetDiffPercent === 0 ? '' : calcBudgetDiffPercent > 0 ? 'bi-arrow-up' : 'bi-arrow-down' ]"
                                    v-html="formatAsPercent(calcBudgetDiffPercent)"
                                ></span>
                            </h5>
                        </template>
                        <template #body>
                            <div class="d-flex align-items-center">
                                <div
                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 v-html="formatAsRUB(props.product.budgetActual)"></h6>
                                    <span
                                        class="text-success small pt-1 fw-bold"
                                        v-html="formatAsRUB(props.product.budgetPlan)"
                                    ></span><span
                                    class="text-muted small pt-2 ps-1"> | план</span>
                                </div>
                            </div>
                        </template>
                    </TheCard>
                </div>
                <div class="col-3">
                    <TheCard class="info-card sales-card">
                        <template #header>
                            <h5 class="mb-0 card-title p-0">Продажи</h5>
                            <h5 :class="[ 'mb-0 fw-bold', calcDiffPercentColorInverse(calcSalesDiffPercent) ]">
                                <span
                                    :class="['bi', calcSalesDiffPercent === 0 ? '' : calcSalesDiffPercent > 0 ? 'bi-arrow-up' : 'bi-arrow-down' ]"
                                    v-html="formatAsPercent(calcSalesDiffPercent)"
                                ></span>
                            </h5>
                        </template>
                        <template #body>
                            <div class="d-flex align-items-center">
                                <div
                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 v-html=formatAsItems(props.product.salesOnTime)></h6>
                                    <span
                                        class="text-success small pt-1 fw-bold"
                                        v-html="formatAsItems(props.product.salesPlan)"
                                    ></span> <span
                                    class="text-muted small pt-2 ps-1"> | план</span>
                                </div>
                            </div>
                        </template>
                    </TheCard>
                </div>
                <div class="col-3">
                    <TheCard class="info-card sales-card">
                        <template #header>
                            <h5 class="mb-0 card-title p-0">Прибыль</h5>
                        </template>
                        <template #body>
                            <div class="d-flex align-items-center">
                                <div
                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-exchange"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 v-html="formatAsRUB(props.product.profitPerProductActual)"></h6>
                                    <span
                                        class="text-success small pt-1 fw-bold"
                                        v-html="formatAsRUB(props.product.profitPerProductPlan)"
                                    ></span><span
                                    class="text-muted small pt-2 ps-1"> | план</span>
                                </div>
                            </div>
                        </template>
                    </TheCard>
                </div>
                <div class="col-3">
                    <TheCard class="info-card profit-card">
                        <template #header>
                            <h5 class="mb-0 card-title p-0">Выручка</h5>
                        </template>
                        <template #body>
                            <div class="d-flex align-items-center">
                                <div
                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 v-html="formatAsRUB(props.product.revenueActual)"></h6>
                                    <span
                                        class="text-success small pt-1 fw-bold"
                                        v-html="formatAsRUB(props.product.revenuePlan)"
                                    ></span><span
                                    class="text-muted small pt-2 ps-1"> | план</span>
                                </div>
                            </div>
                        </template>
                    </TheCard>
                </div>
            </div>
        </template>
    </TheCard>

    <TheModal
        v-if="modals.editModalPopUp"
        v-model="modals.editModalPopUp"
        id="editModalPopUp"
        :custom-classes="['modal-lg']"
    >
        <template #title>
            <h4 class="mb-0">Редактирование акционного продукта</h4>
        </template>
        <template #body>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm border-bottom">
                        <tbody>
                        <tr>
                            <td class="text-secondary">Группа товара</td>
                            <th scope="col" class="text-end">{{ props.product.categoryName }}</th>
                        </tr>
                        <tr>
                            <td class="text-secondary">Продукт</td>
                            <th scope="col" class="text-end">{{ props.product.productName }}</th>
                        </tr>
                        <tr>
                            <td class="text-secondary">Акционная цена</td>
                            <th scope="col" class="text-end">{{ formatNumberWithFractions(props.product.promoPrice) }} руб.</th>
                        </tr>
                        <tr>
                            <td class="text-secondary">Скидка</td>
                            <th scope="col" class="text-end">{{ props.product.discount }}&#8239;%</th>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm border-bottom">
                        <tbody>
                        <tr>
                            <td class="text-secondary">Продажи "До акции"</td>
                            <th scope="col" class="text-end">{{ formatNumber(props.product.salesBefore) }} шт.</th>
                        </tr>
                        <tr>
                            <td class="text-secondary">План прироста</td>
                            <th scope="col" class="text-end">{{ formatNumber(props.product.surplusPlan) }}&#8239;%</th>
                        </tr>
                        <tr>
                            <td class="text-secondary">Компенсация на 1 шт.</td>
                            <th scope="col" class="text-end">{{ formatNumberWithFractions(props.product.compensation) }} руб.</th>
                        </tr>
                        <tr>
                            <td class="text-secondary">Прибыль на 1 шт.</td>
                            <th scope="col" class="text-end">{{ formatNumberWithFractions(props.product.profitPerUnit) }} руб.</th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <Alert/>
            <div class="row mb-3 g-3">
                <div class="col-md-3">
                    <TheLabel for="sales_plan">Продажи, план</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="sales_plan"
                            :model-value="formatNumber(props.product.salesPlan)"
                            class="text-end bg-warning-light"
                            readonly="readonly"
                            :tabindex="-1"
                        />
                        <span class="input-group-text">шт.</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <TheLabel for="sales_on_time" required>Продажи, факт</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="sales_on_time"
                            v-model="state.form.salesOnTime"
                            class="text-end"
                            @blur="processInputValue($event.target.value, 'sales_on_time')"
                        />
                        <span class="input-group-text">шт.</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <TheLabel for="sales_diff">Продажи, факт - план</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="sales_diff"
                            :model-value="formatNumber(calcSalesDiff)"
                            :class="['text-end fw-bold', calcDiffClassInverse(calcSalesDiff)]"
                            readonly="readonly"
                            :tabindex="-1"
                        />
                        <span class="input-group-text">шт.</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <TheLabel for="sales_diff_percent">Продажи, отклонение</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="sales_diff_percent"
                            :model-value="formatNumber(calcSalesDiffPercent)"
                            :class="['text-end fw-bold', calcDiffClassInverse(calcSalesDiffPercent)]"
                            readonly="readonly"
                            :tabindex="-1"
                        />
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3 g-3">
                <div class="col-md-3">
                    <TheLabel for="budget_plan">Бюджет, план</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="budget_plan"
                            :model-value="formatNumberWithFractions(props.product.budgetPlan)"
                            class="text-end bg-warning-light"
                            readonly="readonly"
                            :tabindex="-1"
                        /> <!--@blur="processInputValue($event.target.value, 'budget_plan')"-->
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <TheLabel for="budget_actual">Бюджет, факт</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="budget_actual"
                            :model-value="formatNumberWithFractions(state.form.budgetActual)"
                            class="text-end bg-warning-light"
                            readonly="readonly"
                            :tabindex="-1"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <TheLabel for="budget_diff">Бюджет, факт - план</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="budget_diff"
                            :model-value="formatNumberWithFractions(calcBudgetDiff)"
                            :class="['text-end fw-bold', calcDiffClass(calcBudgetDiff)]"
                            readonly="readonly"
                            :tabindex="-1"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <TheLabel for="budget_diff_percent">Бюджет, отклонение</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="budget_diff_percent"
                            :model-value="formatNumber(calcBudgetDiffPercent)"
                            :class="['text-end fw-bold', calcDiffClass(calcBudgetDiffPercent)]"
                            readonly="readonly"
                            :tabindex="-1"
                        />
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3 g-3">
                <div class="col-md-3">
                    <TheLabel for="profit_per_product_plan">Прибыль, план</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="profit_per_product_plan"
                            :model-value="formatNumberWithFractions(props.product.profitPerProductPlan)"
                            class="text-end bg-warning-light"
                            readonly="readonly"
                            :tabindex="-1"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <TheLabel for="profit_per_product_actual">Прибыль, факт</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="profit_per_product_actual"
                            :model-value="formatNumberWithFractions(state.form.profitPerProductActual)"
                            class="text-end bg-warning-light"
                            readonly="readonly"
                            :tabindex="-1"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <TheLabel for="profit_per_product_diff">Прибыль, факт - план</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="profit_per_product_diff"
                            :model-value="formatNumberWithFractions(calcProfitPerProductDiff)"
                            :class="['text-end fw-bold', calcDiffClassInverse(calcProfitPerProductDiff)]"
                            readonly="readonly"
                            :tabindex="-1"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <TheLabel for="profit_per_product_diff_percent">Прибыль, отклонение</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="profit_per_product_diff_percent"
                            :model-value="formatNumber(calcProfitPerProductDiffPercent)"
                            :class="['text-end fw-bold', calcDiffClassInverse(calcProfitPerProductDiffPercent)]"
                            readonly="readonly"
                            :tabindex="-1"
                        />
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <TheLabel for="revenue_plan">Выручка, план</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="revenue_plan"
                            :model-value="formatNumberWithFractions(props.product.revenuePlan)"
                            class="text-end bg-warning-light"
                            readonly="readonly"
                            :tabindex="-1"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <TheLabel for="revenue_actual">Выручка, факт</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="revenue_actual"
                            :model-value="formatNumberWithFractions(state.form.revenueActual)"
                            class="text-end bg-warning-light"
                            readonly="readonly"
                            :tabindex="-1"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <TheLabel for="revenue_diff">Выручка, факт - план</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="revenue_diff"
                            :model-value="formatNumberWithFractions(calcRevenueDiff)"
                            :class="['text-end fw-bold', calcDiffClassInverse(calcRevenueDiff)]"
                            readonly="readonly"
                            :tabindex="-1"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <TheLabel for="revenue_diff_percent">Выручка, отклонение</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="revenue_diff_percent"
                            :model-value="formatNumber(calcRevenueDiffPercent)"
                            :class="['text-end fw-bold', calcDiffClassInverse(calcRevenueDiffPercent)]"
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
                :disabled="spinnerStore.isButtonDisabled || isNaN(convertInputStringToNumber(state.form.salesOnTime))"
                :loading="spinnerStore.isButtonDisabled"
                type="button"
                class="btn-warning w-25"
                @click="saveChangesHandler"
            >Сохранить изменения</TheButton>
        </template>
    </TheModal>
</template>

<script setup>
import { computed, reactive, watch } from 'vue';
import TheButton from '@/components/core/TheButton.vue';
import TheModal from '@/components/TheModal.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import TheInput from '@/components/form/TheInput.vue';
import TheCard from '@/components/core/TheCard.vue';
import Alert from '@/components/Alert.vue';
import { useCalculations } from '@/use/useCalculations.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useHttpService } from '@/use/useHttpService.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useConvertCase } from '@/use/useConvertCase.js';
import {
    convertInputStringToNumber,
    formatAsItems,
    formatAsPercent,
    formatAsRUB,
    formatNumber,
    formatNumberWithFractions,
    processInputValue,
} from '@/helpers/formatters.js';
import { MANAGER_URLS } from '@/helpers/constants.js';

const {
    calcDifferencePercentage,
    calcBudget,
    calcDifference,
    calcDiffClass,
    calcDiffClassInverse,
    calcDiffPercentColor,
    calcDiffPercentColorInverse,
} = useCalculations();
const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const { makeConvertibleObject, toCamel } = useConvertCase();
const { update } = useHttpService();

const props = defineProps({
    index: {
        type: Number,
        default: 0,
    },
    promoId: {
        type: Number,
        required: true,
    },
    product: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits([
    'updateProductItem',
]);

const modals = reactive({
    editModalPopUp: false,
});

// TODO: delete commented lines
const initialFormData = () => ({
    id: props.product.id,
    // salesBefore: props.product.salesBefore,
    // salesPlan: props.product.salesPlan,
    salesOnTime: formatNumber(props.product.salesOnTime),
    // surplusPlan: props.product.surplusPlan,
    surplusActual: props.product.surplusActual,
    // budgetPlan: props.product.budgetPlan,
    budgetActual: props.product.budgetActual,
    // compensation: props.product.compensation,
    // profitPerUnit: props.product.profitPerUnit,
    // profitPerProductPlan: props.product.profitPerProductPlan,
    profitPerProductActual: props.product.profitPerProductActual,
    // revenuePlan: props.product.revenuePlan,
    revenueActual: props.product.revenueActual,
});

const state = reactive({
    form: initialFormData(),
});

const handleBtnClick = () => {
    alertStore.clear();
    modals.editModalPopUp = true;
    state.form = initialFormData();
};

const saveChangesHandler = async () => {
    const updatedProduct = processObjectEntries();
    const response = await update(`${ MANAGER_URLS.PROMO }/${ props.promoId }${ MANAGER_URLS.PRODUCT }/${ updatedProduct.id }`, updatedProduct);
    if ( response && response.status === 'success' ) {
        const data = makeConvertibleObject(JSON.parse(response.data), toCamel);
        emit('updateProductItem', data);
        modals.editModalPopUp = false;
    }
};

const processObjectEntries = () => {
    const obj = {};
    Object.keys(state.form).map(key => obj[key] = convertInputStringToNumber(state.form[key]));
    return obj;
};

watch(() => state.form.salesOnTime,
    (newValue) => {
        const salesOnTime = convertInputStringToNumber(newValue);
        if ( !isNaN(salesOnTime) ) {
            calcSurplusActual(salesOnTime);
            calcBudgetActual(salesOnTime);
            calcProfitActual(salesOnTime);
            calcRevenueActual(salesOnTime);
        }
    },
);

const calcSurplusActual = (salesOnTime) => {
    state.form.surplusActual = calcDifferencePercentage(props.product.salesBefore, salesOnTime);
};

const calcBudgetActual = (salesOnTime) => {
    state.form.budgetActual = calcBudget(salesOnTime, props.product.compensation);
};

const calcProfitActual = (salesOnTime) => {
    state.form.profitPerProductActual = props.product.profitPerUnit * salesOnTime;
};

const calcRevenueActual = (salesOnTime) => {
    state.form.revenueActual = Math.round(salesOnTime * props.product.promoPrice);
};

const calcSalesDiff = computed(() => {
    const salesOnTime = convertInputStringToNumber(state.form.salesOnTime);
    return !isNaN(salesOnTime) ? calcDifference(props.product.salesPlan, salesOnTime) : calcDifference(props.product.salesPlan, 0);
});

const calcBudgetDiff = computed(() => {
    return calcDifference(props.product.budgetPlan, state.form.budgetActual);
});

const calcProfitPerProductDiff = computed(() => {
    return calcDifference(props.product.profitPerProductPlan, state.form.profitPerProductActual);
});

const calcRevenueDiff = computed(() => {
    return calcDifference(props.product.revenuePlan, state.form.revenueActual);
});

const calcSalesDiffPercent = computed(() => {
    const salesOnTime = convertInputStringToNumber(state.form.salesOnTime);
    return !isNaN(salesOnTime) ? calcDifferencePercentage(props.product.salesPlan, salesOnTime) : calcDifferencePercentage(props.product.salesPlan, 0);
});

const calcBudgetDiffPercent = computed(() => {
    return calcDifferencePercentage(props.product.budgetPlan, state.form.budgetActual);
});

const calcProfitPerProductDiffPercent = computed(() => {
    return calcDifferencePercentage(props.product.profitPerProductPlan, state.form.profitPerProductActual);
});

const calcRevenueDiffPercent = computed(() => {
    return calcDifferencePercentage(props.product.revenuePlan, state.form.revenueActual);
});
</script>
