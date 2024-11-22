<template>
    <div>
        <div class="card">
            <div class="card-header bg-secondary text-white">{{ props.title }}</div>
            <div class="card-body mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Участники из команды ТП</span>
                </div>
                <hr>
                <pre>
                    {{ state.checkedSellers }}
                </pre>
                <h5>Мотивация для расчёта бюджета: <span class="fw-bold text-primary">{{ state.form.compensation }}&#8239;%</span></h5>
                <h5 class="mb-3">Планируемый бюджет на промо-акцию: <span class="fw-bold text-primary">{{ formatNumber(totalBudget) }} руб.</span></h5>
                <p>Выберите торговых представителей, участвующих в акции:</p>
                <div v-if="filteredSellers.length === 0">
                    <p>В команду дистрибьютора не добавлено ни одного торгового представителя. <RouterLink :to="{ name: 'Manager.Customer.View', params: { id: props.customerId }}" class="fw-bold">Перейдите в карточку контрагента</RouterLink> на вкладку "Команда ТП" и добавьте торговых представителей.</p>
                </div>
                <div v-else>
                    <ul class="list-group">
                        <li class="list-group-item m-0">
                            <div class="row text-center">
                                <div class="col-5">ФИО</div>
                                <div class="col-2">Продажи, факт</div>
                                <div class="col-2">План, %</div>
                                <div class="col-2">Продажи, план</div>
                                <div class="col-1">Del</div>
                            </div>
                        </li>
                        <li
                            v-for="(seller, index) in filteredSellers"
                            class="list-group-item m-0"
                        >
                            <div class="row g-2">
                                <div class="col-5">
                                    <div class="input-group">
                                        <span class="input-group-text">{{ index + 1 }}</span>
                                        <input
                                            type="text"
                                            class="form-control"
                                            :value="seller.shortName"
                                            readonly
                                        >
                                    </div>
                                </div>
                                <div class="col-2">
                                    <input
                                        :id="`${index}_salesBefore`"
                                        @input="onSalesBeforeChange($event, index)"
                                        class="form-control text-end"
                                        type="text"
                                    >
                                </div>
                                <div class="col-2">
                                    <input
                                        :id="`${index}_surplusPlan`"
                                        @input="onSurplusPlanChange($event, index)"
                                        class="form-control text-end"
                                        type="text"
                                        readonly
                                    >
                                </div>
                                <div class="col-2">
                                    <input
                                        :id="`${index}_salesPlan`"
                                        @input="onSalesPlanChange($event, index)"
                                        class="form-control text-end"
                                        type="text"
                                        readonly
                                    >
                                </div>
                                <div class="col-1 text-center">
                                    <button
                                        @click="removeSeller(seller.id, index)"
                                        class="btn btn-outline-danger"
                                    ><i class="bi-x-lg"></i></button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, reactive } from 'vue';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import { convertInputStringToNumber, formatNumber } from '@/helpers/formatters.js';
import { BOOST_QUOTIENT, DEFAULT_SURPLUS_PERCENT } from '@/helpers/constants.js';

const { get } = useHttpService();
const arrayHandlers = useArrayHandlers();

const initialFormData = () => ({
    sellerId: '',
    salesBefore: 0,
    salesPlan: 0,
    surplusPlan: 0,
    salesAfter: 0,
    compensation: BOOST_QUOTIENT,
    budgetPlan: 0,
    budgetActual: 0,
});

const props = defineProps({
    title: {
        type: String,
        required: true,
        default: 'Title is required',
    },
    customerId: {
        type: Number,
        required: true,
    },
    sellers: {
        type: Array,
        required: true,
        default: [],
    },
});

const emit = defineEmits([
   'addSellersToPromo',
]);

const state = reactive({
    checkedSellers: [],
    form: initialFormData(),
});

const filteredSellers = computed(() => {
    const tempArr = props.sellers
        .filter(seller => seller.isActive)
        .map(item => ({ ...item, ...state.form })
    );
    return arrayHandlers.sortArrayByStringColumn(tempArr, 'name');
});

const onSalesBeforeChange = (evt, index) => {
    let sellerObj = filteredSellers.value[index];
    const itemIdx = state.checkedSellers.findIndex(ch => ch.id === sellerObj.id);

    if (itemIdx === -1) {
        state.checkedSellers.push(sellerObj);
        emit('addSellersToPromo', state.checkedSellers);
    } else {
        sellerObj = state.checkedSellers[itemIdx];
    }

    const salesBeforeValue = evt.target.value;

    const salesBeforeEl = document.getElementById(`${index}_salesBefore`);
    const surplusPlanEl = document.getElementById(`${index}_surplusPlan`);
    const salesPlanEl = document.getElementById(`${index}_salesPlan`);

    let salesBefore = convertInputStringToNumber(salesBeforeValue);

    let surplusPlan;
    let salesPlan;
    let budgetPlan;

    if (salesBeforeValue === '') {
        surplusPlan = 0;
        salesPlan = 0;
        budgetPlan = 0;

        surplusPlanEl.value = '';
        salesPlanEl.value = '';
        surplusPlanEl.setAttribute('readonly', 'readonly');
        salesPlanEl.setAttribute('readonly', 'readonly');

        state.checkedSellers.splice(itemIdx, 1);
    } else if (salesBefore === 0) {
        salesBefore = 0;
        surplusPlan = 0;
        salesPlan = 0;
        budgetPlan = 0;

        surplusPlanEl.value = surplusPlan;
        surplusPlanEl.setAttribute('readonly', 'readonly');
        salesPlanEl.removeAttribute('readonly');
    } else {
        surplusPlan = surplusPlanEl.value === ''
            ? DEFAULT_SURPLUS_PERCENT
            : convertInputStringToNumber(surplusPlanEl.value);
        salesPlan = +(salesBefore + (salesBefore * surplusPlan) / 100).toFixed(2);
        budgetPlan = +(salesPlan / sellerObj.compensation).toFixed(2);

        salesBeforeEl.value = formatNumber(salesBefore);
        salesPlanEl.value = formatNumber(salesPlan);
        salesPlanEl.setAttribute('readonly', 'readonly');
        surplusPlanEl.removeAttribute('readonly');
        surplusPlanEl.value = surplusPlan;
    }

    sellerObj.sellerId = sellerObj.id;
    sellerObj.salesBefore = salesBefore;
    sellerObj.surplusPlan = surplusPlan;
    sellerObj.salesPlan = salesPlan;
    sellerObj.budgetPlan = budgetPlan;
};

const onSurplusPlanChange = (evt, index) => {
    let sellerObj = filteredSellers.value[index];
    const itemIdx = state.checkedSellers.findIndex(ch => ch.id === sellerObj.id);

    if (itemIdx === -1) {
        state.checkedSellers.push(sellerObj);
        emit('addSellersToPromo', state.checkedSellers);
    } else {
        sellerObj = state.checkedSellers[itemIdx];
    }

    const surplusPlanValue = evt.target.value;

    const salesBeforeEl = document.getElementById(`${index}_salesBefore`);
    const surplusPlanEl = document.getElementById(`${index}_surplusPlan`);
    const salesPlanEl = document.getElementById(`${index}_salesPlan`);

    let salesBefore = convertInputStringToNumber(salesBeforeEl.value);
    let surplusPlan = convertInputStringToNumber(surplusPlanValue);
    let salesPlan;
    let budgetPlan;

    if (surplusPlanValue === '' || isNaN(surplusPlan)) {
        surplusPlan = 0;
        surplusPlanEl.value = surplusPlan;
    }

    salesPlan = +(salesBefore + (salesBefore * surplusPlan) / 100).toFixed(2);
    budgetPlan = +(salesPlan / sellerObj.compensation).toFixed(2);

    surplusPlanEl.value = formatNumber(surplusPlan);
    salesPlanEl.value = formatNumber(salesPlan);

    sellerObj.sellerId = sellerObj.id;
    sellerObj.salesBefore = salesBefore;
    sellerObj.surplusPlan = surplusPlan;
    sellerObj.salesPlan = salesPlan;
    sellerObj.budgetPlan = budgetPlan;
};

const onSalesPlanChange = (evt, index) => {
    let sellerObj = filteredSellers.value[index];
    const itemIdx = state.checkedSellers.findIndex(ch => ch.id === sellerObj.id);
    sellerObj = state.checkedSellers[itemIdx];

    const salesPlanValue = evt.target.value;
    let salesPlan = convertInputStringToNumber(salesPlanValue);
    const salesPlanEl = document.getElementById(`${index}_salesPlan`);

    let salesBefore = 0;
    let surplusPlan = 0;
    let budgetPlan;

    if ( salesPlanValue === '' || isNaN(salesPlan) ) {
        salesPlan = 0;
        salesPlanEl.value = salesPlan;
    } else {
        budgetPlan = +(salesPlan / sellerObj.compensation).toFixed(2);
        salesPlan = +(salesPlan).toFixed(2);
        salesPlanEl.value = formatNumber(salesPlan);
    }

    sellerObj.salesBefore = salesBefore;
    sellerObj.surplusPlan = surplusPlan;
    sellerObj.salesPlan = salesPlan;
    sellerObj.budgetPlan = budgetPlan;
};

const totalBudget = computed(() => {
    return state.checkedSellers.reduce((acc, seller) => {
        return acc + parseInt(seller.budgetPlan);
    }, 0);
});

const removeSeller = (id, index) => {
    const itemIdx = state.checkedSellers.findIndex(ch => ch.id === id);

    if (itemIdx !== -1) {
        const salesBeforeEl = document.getElementById(`${index}_salesBefore`);
        const surplusPlanEl = document.getElementById(`${index}_surplusPlan`);
        const salesPlanEl = document.getElementById(`${index}_salesPlan`);

        salesBeforeEl.value = '';
        surplusPlanEl.value = '';
        salesPlanEl.value = '';

        state.checkedSellers.splice(itemIdx, 1);
    }
};
</script>
