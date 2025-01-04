<template>
    <TheCard :header-classes="['bg-secondary-subtle py-2']">
        <template #header>
            <h5 class="mb-0">{{ props.index + 1 }}. {{ product.categoryName }}&nbsp;<span
                class="text-primary fw-bold">|&nbsp;{{ product.productName }}</span></h5>
            <TheButton
                class="btn-warning"
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
                        </template>
                        <template #body>
                            <div class="d-flex align-items-center">
                                <div
                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ formatNumber(product.budgetActual) }} &#8381;</h6>
                                    <span class="text-success small pt-1 fw-bold">{{
                                            formatNumber(product.budgetPlan)
                                        }} &#8381;</span><span
                                    class="text-muted small pt-2 ps-1"> | план</span>
                                </div>
                            </div>
                        </template>
                    </TheCard>
                </div>
                <div class="col-3">
                    <TheCard class="info-card sales-card">
                        <template #header>
                            <h5 class="mb-0 card-title p-0">Продажи "До"</h5>
                            <!--    TODO                        <h5 :class="['mb-0 fw-bold', calcSurplusTextColor]"><i
                                                            :class="['bi', calcSurplus >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ]"></i>&nbsp;{{
                                                                calcSurplus
                                                            }}&#8239;%</h5>-->
                        </template>
                        <template #body>
                            <div class="d-flex align-items-center">
                                <div
                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ formatNumber(product.salesOnTime) }} шт.</h6>
                                    <span class="text-success small pt-1 fw-bold">{{
                                            formatNumber(product.salesPlan)
                                        }} шт.</span> <span
                                    class="text-muted small pt-2 ps-1"> | план</span>
                                </div>
                            </div>
                        </template>
                    </TheCard>
                </div>
                <div class="col-3">
                    <TheCard class="info-card sales-card">
                        <template #header>
                            <h5 class="mb-0 card-title p-0">Продажи "Во время"</h5>
                            <!--                            <h5 :class="['mb-0 fw-bold', calcSurplusTextColor]"><i
                                                            :class="['bi', calcSurplus >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ]"></i>&nbsp;{{
                                                                calcSurplus
                                                            }}&#8239;%</h5>-->
                        </template>
                        <template #body>
                            <div class="d-flex align-items-center">
                                <div
                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ formatNumber(product.salesOnTime) }} шт.</h6>
                                    <span class="text-success small pt-1 fw-bold">{{
                                            formatNumber(product.salesPlan)
                                        }} шт.</span> <span
                                    class="text-muted small pt-2 ps-1"> | план</span>
                                </div>
                            </div>
                        </template>
                    </TheCard>
                </div>
                <div class="col-3">
                    <TheCard class="info-card profit-card">
                        <template #header>
                            <h5 class="mb-0 card-title p-0">Прибыль на SKU</h5>
                        </template>
                        <template #body>
                            <div class="d-flex align-items-center">
                                <div
                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ formatNumber(product.promoProfit) }} &#8381;</h6>
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
        :custom-classes="['modal-xl']"
    >
        <template #title>
            <h4 class="mb-0">Редактирование акционного продукта</h4>
        </template>
        <template #body>
            <h5>Группа товара: <span class="fw-bold text-primary">{{ product.categoryName }}</span></h5>
            <h5>Продукт: <span class="fw-bold text-primary">{{ product.productName }}</span></h5>
            <hr>
            <Alert/>
            <div class="row mb-3 g-3">
                <div class="col-md-2">
                    <TheLabel for="sales_before">Продажи "До акции"</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="sales_before"
                            v-model="state.form.salesBefore"
                            type="text"
                            class="text-end bg-warning-light"
                            @blur="processInputValue($event.target.value, 'sales_before')"
                        />
                        <span class="input-group-text">шт.</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <TheLabel for="sales_plan">План продаж</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="sales_plan"
                            v-model="state.form.salesPlan"
                            type="text"
                            class="text-end bg-warning-light"
                            @blur="processInputValue($event.target.value, 'sales_plan')"
                        />
                        <span class="input-group-text">шт.</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <TheLabel for="surplus_plan">План прироста</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="surplus_plan"
                            type="text"
                            :model-value="calcSurplusPlan"
                            class="text-end bg-warning-light"
                            readonly="readonly"
                        />
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <TheLabel for="sales_on_time" required>Продажи "Во время"</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="sales_on_time"
                            v-model="state.form.salesOnTime"
                            type="text"
                            class="text-end"
                            @blur="processInputValue($event.target.value, 'sales_on_time')"
                        />
                        <span class="input-group-text">шт.</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <TheLabel for="surplus_actual">Факт прироста</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="surplus_actual"
                            type="text"
                            :model-value="calcSurplusActual"
                            class="text-end bg-warning-light"
                            readonly="readonly"
                        />
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <TheLabel for="surplus_diff">Отклонение</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="surplus_diff"
                            type="text"
                            :model-value="calcSurplusDiff"
                            class="text-end fw-bold"
                            :class="calcSurplusDiffClass"
                            readonly="readonly"
                        />
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-2">
                    <TheLabel for="budget_plan">Бюджет, план</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="budget_plan"
                            v-model="state.form.budgetPlan"
                            type="text"
                            class="text-end bg-warning-light"
                            @blur="processInputValue($event.target.value, 'budget_plan')"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <TheLabel for="budget_actual">Бюджет, факт</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="budget_actual"
                            type="text"
                            v-model="state.form.budgetActual"
                            class="text-end bg-warning-light"
                            readonly="readonly"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <TheLabel for="budget_diff">Бюджет, факт - план</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="budget_diff"
                            type="text"
                            v-model="state.form.budgetDiff"
                            class="text-end fw-bold"
                            :class="calcBudgetDiffClass"
                            readonly="readonly"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <TheLabel for="compensation">Компенсация на 1 шт.</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="compensation"
                            v-model="state.form.compensation"
                            type="text"
                            class="text-end bg-warning-light"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <TheLabel for="profit_per_unit" required>Прибыль на 1 шт.</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="profit_per_unit"
                            v-model="state.form.profitPerUnit"
                            type="text"
                            class="text-end bg-warning-light"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <TheLabel for="total_profit" required>Прибыль на SKU</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="total_profit"
                            v-model="state.form.promoProfit"
                            type="text"
                            class="text-end bg-warning-light"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <TheButton
                :disabled="spinnerStore.isButtonDisabled"
                :loading="spinnerStore.isButtonDisabled"
                type="button"
                class="btn-warning w-25"
                @click="saveChangesHandler"
            >Сохранить изменения</TheButton>
        </template>
    </TheModal>
</template>

<script setup>
import { computed, reactive } from 'vue';
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
import { convertInputStringToNumber, formatNumber, isNumberNegative, processInputValue } from '@/helpers/formatters.js';
import { MANAGER_URLS } from '@/helpers/constants.js';

const { calcDifferencePercentage, calcBudget } = useCalculations();
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

const initialFormData = () => ({
    id: props.product.id.toString(),
    salesBefore: formatNumber(props.product.salesBefore),
    salesPlan: formatNumber(props.product.salesPlan),
    salesOnTime: formatNumber(props.product.salesOnTime),
    profitPerUnit: props.product.profitPerUnit,
    compensation: props.product.compensation,
    budgetPlan: formatNumber(props.product.budgetPlan),
    budgetActual: formatNumber(props.product.budgetActual),
    budgetDiff: '',
    promoProfit: '',
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
    const response = await update(`${MANAGER_URLS.PROMO}/${props.promoId}${MANAGER_URLS.PRODUCT}/${updatedProduct.id}`, updatedProduct);
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

const calcSurplusPlan = computed(() => {
    const result = calcDifferencePercentage(state.form.salesBefore, state.form.salesPlan);
    if ( !isNaN(result) ) {
        return formatNumber(result);
    }
});

const calcSurplusActual = computed(() => {
    const result = calcDifferencePercentage(state.form.salesBefore, state.form.salesOnTime);
    if ( !isNaN(result) ) {
        calcBudgetActual();
        return formatNumber(result);
    }
});

const calcSurplusDiff = computed(() => {
    let result = 0;
    const planStr = calcSurplusPlan.value;
    const actualStr = calcSurplusActual.value;
    let planNum, actualNum;

    if ( planStr !== undefined && actualStr !== undefined ) {
        planNum = isNumberNegative(planStr)
            ? -1 * convertInputStringToNumber(planStr)
            : convertInputStringToNumber(planStr);

        actualNum = isNumberNegative(actualStr)
            ? -1 * convertInputStringToNumber(actualStr)
            : convertInputStringToNumber(actualStr);

        result = actualNum - planNum;
    }

    return formatNumber(result);
});

const calcSurplusDiffClass = computed(() => {
    return isNumberNegative(calcSurplusDiff.value)
        ? 'bg-danger-subtle text-danger'
        : calcSurplusDiff.value.toString() === '0'
            ? 'bg-warning-subtle text-black'
            : 'bg-success-subtle text-success';
});

const calcBudgetActual = () => {
    state.form.budgetActual = formatNumber(calcBudget(state.form.salesOnTime, state.form.compensation));
    calcBudgetDiff();
    calcPromoProfit();
};

const calcBudgetDiff = () => {
    const planNum = convertInputStringToNumber(state.form.budgetPlan);
    const actualNum = convertInputStringToNumber(state.form.budgetActual);
    state.form.budgetDiff = formatNumber(actualNum - planNum);
};

const calcPromoProfit = () => {
    const salesOnTimeNum = convertInputStringToNumber(state.form.salesOnTime);
    state.form.promoProfit = formatNumber(state.form.profitPerUnit * salesOnTimeNum);
};

const calcBudgetDiffClass = computed(() => {
    if ( state.form.budgetDiff ) {
        const budgetDiffNum = convertInputStringToNumber(state.form.budgetDiff);
        return isNumberNegative(state.form.budgetDiff)
            ? 'bg-success-subtle text-success'
            : budgetDiffNum === 0
                ? 'bg-warning-subtle text-black'
                : 'bg-danger-subtle text-danger';
    } else {
        return 'bg-warning-subtle text-black';
    }
});
</script>
