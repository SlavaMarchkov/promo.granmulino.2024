<template>
    <li class="list-group-item m-0 px-3">
        <div class="row align-items-center g-1">
            <div class="col-md-1 text-center">{{ index + 1 }}</div>
            <div class="col-md-4 fw-bold">{{ product.categoryName }} / {{ product.productName }}</div>
            <div class="col-md-2 border">some3</div>
            <div class="col-md-2">some4</div>
            <div class="col-md-2">some5</div>
            <div class="col-md-1">
                <TdButton
                    :id="product.id"
                    intent="edit"
                    class="w-100"
                    @runButtonHandler="modals.editModalPopUp = true"
                >Edit</TdButton>
            </div>
        </div>
    </li>

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
                            @blur="processInputValue($event, 'sales_before')"
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
                            @blur="processInputValue($event, 'sales_plan')"
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
                            @blur="processInputValue($event, 'sales_on_time')"
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
                            ref="surplusDiffRef"
                            id="surplus_diff"
                            type="text"
                            :model-value="calcSurplusDiff"
                            class="text-end fw-bold"
                            readonly="readonly"
                        />
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="row g-3">

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
import { computed, onMounted, reactive, ref } from 'vue';
import { useCalculations } from '@/use/useCalculations.js';
import { convertInputStringToNumber, formatNumber } from '@/helpers/formatters.js';
import TheButton from '@/components/core/TheButton.vue';
import TheModal from '@/components/TheModal.vue';
import TdButton from '@/components/table/TdButton.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import TheInput from '@/components/form/TheInput.vue';

const { calcSurplusPercent } = useCalculations();

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
    categoryId: '',
    productId: '',
    salesBefore: props.product.salesBefore,
    salesPlan: props.product.salesPlan,
    salesOnTime: '',
    salesAfter: '',
    profitPlan: props.product.profitPlan,
    profitActual: '',
    compensation: props.product.compensation,
    budgetPlan: props.product.budgetPlan,
    budgetActual: '',
});

const state = reactive({
    form: initialFormData(),
});

const surplusDiffRef = ref(null);

onMounted(() => {
    console.log(surplusDiffRef.value);
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

const processInputValue = (evt, el) => {
    const inputEl = document.getElementById(el);
    inputEl.value = formatNumber(convertInputStringToNumber(evt.target.value));
};

const calcSurplusPlan = computed(() => {
    const result = calcSurplusPercent(state.form.salesBefore, state.form.salesPlan);
    if ( !isNaN(result) ) {
        return formatNumber(result);
    }
});

const calcSurplusActual = computed(() => {
    const result = calcSurplusPercent(state.form.salesBefore, state.form.salesOnTime);
    if ( !isNaN(result) ) {
        return formatNumber(result);
    }
});

const calcSurplusDiff = computed(() => {
    let result = 0;

    if ( calcSurplusActual.value !== undefined && calcSurplusPlan.value !== undefined ) {
        //const inputEl = document.getElementById('surplus_diff');
        result = convertInputStringToNumber(calcSurplusActual.value) - convertInputStringToNumber(calcSurplusPlan.value);

        /*if (result < 0) {
            inputEl.classList.remove('bg-success-light');
            inputEl.classList.remove('text-success');
            inputEl.classList.add('bg-danger-light');
            inputEl.classList.add('text-danger');
        } else {
            inputEl.classList.remove('bg-danger-light');
            inputEl.classList.remove('text-danger');
            inputEl.classList.add('bg-success-light');
            inputEl.classList.add('text-success');
        }*/
    }

    return formatNumber(result);
});
</script>
