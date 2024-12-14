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
                    <div class="col-7">Продажи "До"</div>
                    <div class="col-5 fw-bold text-end">{{ formatNumber(product.salesBefore) }} шт.</div>
                </div>
                <div class="row">
                    <div class="col-6">План</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(product.salesPlan) }} шт.</div>
                </div>
                <div class="row">
                    <div class="col-7">Прирост</div>
                    <div class="col-5 fw-bold text-end">{{ formatNumber(product.surplusPlan) }}&#8239;%</div>
                </div>
                <div class="row">
                    <div class="col-6">Бюджет</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(product.budgetPlan) }} руб.</div>
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
            <p class="mb-1">Группа товара: <span class="fw-bold text-primary">{{ product.categoryName }}</span></p>
            <p class="mb-1">Продукт: <span class="fw-bold text-primary">{{ product.productName }}</span></p>
        </template>
        <template #body>
            <pre>{{ props.product }}</pre>
            <pre>{{ state.form }}</pre>
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
                    <TheLabel for="sales_on_time">Продажи "Во время"</TheLabel>
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
                    <TheLabel for="budget_plan" required>Бюджет, план</TheLabel>
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
                    <TheLabel for="compensation" required>Компенсация на 1 шт.</TheLabel>
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
                <div class="col-md-3">
                    <TheLabel for="profit_plan" required>Прибыль на 1 шт.</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="profit_plan"
                            v-model="state.form.profitPlan"
                            type="number"
                            min="0"
                            step="0.01"
                            aria-describedby="profit_plan_help"
                        />
                        <span class="input-group-text">руб.</span>
                    </div>
                    <div id="profit_plan_help" class="form-text">берётся из P&L</div>
                </div>
                <div class="col-md-3">
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
                </div>
                <div class="col-md-3">
                    <TheLabel for="budget_plan" required>Бюджет</TheLabel>
                    <div class="input-group">
                        <TheInput
                            id="budget_plan"
                            v-model="state.form.budgetPlan"
                            type="number"
                            disabled="disabled"
                            aria-describedby="budget_plan_help"
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
                @click="saveProductItem"
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

const { calcDifferencePercentage } = useCalculations();

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

const modals = reactive({
    editModalPopUp: false,
});

const initialFormData = () => ({
    salesBefore: formatNumber(props.product.salesBefore),
    salesPlan: formatNumber(props.product.salesPlan),
    salesOnTime: '',
    salesAfter: '',
    profitPlan: formatNumber(props.product.profitPlan),
    profitActual: '',
    compensation: props.product.compensation,
    budgetPlan: formatNumber(props.product.budgetPlan),
    budgetActual: '',
});

const state = reactive({
    form: initialFormData(),
});

const saveProductItem = async () => {
    console.log('saving...');
    //editModalPopUp.hide();
    // get(`${MANAGER_URLS.PROMO}/${promoId}`);
    /*const response = await post(ADMIN_URLS.CATEGORY, state.category);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        state.category = initialFormData();
        editModalPopUp.hide();
        arrayHandlers.resetSearchKeys(searchBy);
        arrayHandlers.resetSortKeys('id', false);
        await getCategories();
    }*/
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
</script>
