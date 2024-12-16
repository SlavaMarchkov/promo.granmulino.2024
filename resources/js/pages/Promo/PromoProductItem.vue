<template>
    <div class="col">
        <div class="card mb-0">
            <h6 class="card-header bg-secondary-subtle py-2 fw-bold text-black">
                {{ product.categoryName }}</h6>
            <h6 class="card-header py-2 fw-bold text-primary">
                {{ product.productName }}
            </h6>
            <div class="card-body mt-2 pb-2">
                <div class="row">
                    <div class="col-6">Продажи "До"</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(product.salesBefore) }} шт.</div>
                </div>
                <div class="row">
                    <div class="col-6">План</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(product.salesPlan) }} шт.</div>
                </div>
                <div class="row">
                    <div class="col-6">Прирост</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(calcSurplusPlan) }}&#8239;%</div>
                </div>
                <div class="row">
                    <div class="col-6">Бюджет, план</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(product.budgetPlan) }} руб.</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">Продажи "Во время"</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(product.salesOnTime) }} шт.</div>
                </div>
                <div class="row">
                    <div class="col-6">Бюджет, факт</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(product.budgetActual) }} руб.</div>
                </div>
                <div class="row">
                    <div class="col-6">Прибыль на SKU</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(product.totalProfit) }} руб.</div>
                </div>
            </div>
            <div class="card-footer py-2">
                <TdButton
                    :id="product.id"
                    intent="edit"
                    class="w-100"
                    @runButtonHandler="modals.editModalPopUp = true"
                >Редактировать</TdButton>
            </div>
        </div>
    </div>

    <TheModal
        v-if="modals.editModalPopUp"
        v-model="modals.editModalPopUp"
        id="editModalPopUp"
        :custom-classes="['modal-xl']"
    >
        <template #title>
            <h4>Редактирование акционного продукта</h4>
        </template>
        <template #body>
            <h5>Группа товара: <span class="fw-bold text-primary">{{ product.categoryName }}</span></h5>
            <h5>Продукт: <span class="fw-bold text-primary">{{ product.productName }}</span></h5>
            <hr>
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
                    <TheLabel for="budget_diff">Бюджет, план - факт</TheLabel>
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
                class="btn-warning w-25"
                type="button"
                @click="saveChangesHandler"
            >Сохранить изменения</TheButton>
        </template>
    </TheModal>
</template>

<script setup>
import { computed, reactive } from 'vue';
import { useCalculations } from '@/use/useCalculations.js';
import { convertInputStringToNumber, formatNumber, isNumberNegative, processInputValue } from '@/helpers/formatters.js';
import TheButton from '@/components/core/TheButton.vue';
import TheModal from '@/components/TheModal.vue';
import TdButton from '@/components/table/TdButton.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import TheInput from '@/components/form/TheInput.vue';

const { calcDifferencePercentage, calcBudget } = useCalculations();

const props = defineProps({
    index: {
        type: Number,
        default: 1,
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
    budgetActual: '',
    budgetDiff: '',
    promoProfit: '',
});

const state = reactive({
    form: initialFormData(),
});

const saveChangesHandler = () => {
    emit('updateProductItem', processObjectEntries());
    modals.editModalPopUp = false;
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
    state.form.budgetDiff = formatNumber(planNum - actualNum);
};

const calcPromoProfit = () => {
    const salesOnTimeNum = convertInputStringToNumber(state.form.salesOnTime);
    state.form.promoProfit = formatNumber(state.form.profitPerUnit * salesOnTimeNum);
};

const calcBudgetDiffClass = computed(() => {
    if ( state.form.budgetDiff ) {
        const budgetDiffNum = convertInputStringToNumber(state.form.budgetDiff);
        return isNumberNegative(budgetDiffNum)
            ? 'bg-success-subtle text-success'
            : budgetDiffNum === 0
                ? 'bg-warning-subtle text-black'
                : 'bg-danger-subtle text-danger';
    } else {
        return 'bg-warning-subtle text-black';
    }
});
</script>
