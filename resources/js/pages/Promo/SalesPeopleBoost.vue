<template>
    <div>
        <div class="card">
            <div class="card-header bg-secondary text-white">{{ props.title }}</div>
            <div class="card-body mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Планируемый бюджет на промо-акцию:</h4>
                    <h4 class="text-primary fw-bold mb-0">{{ isNaN(totalBudget) ? '0' : formatNumber(totalBudget) }} руб.</h4>
                </div>
                <hr>
                <h5>Мотивация для расчёта бюджета: <span class="fw-bold text-primary">
                    СВ: {{ BOOST_SUPERVISOR_QUOTIENT }}&#8239;% ТП: {{ BOOST_SELLER_QUOTIENT }}&#8239;%</span>
                </h5>
                <p>Введите план для торговых представителей, участвующих в акции:</p>
                <div v-if="props.sellers.length === 0">
                    <p>В команду дистрибьютора не добавлено ни одного торгового представителя. <RouterLink :to="{ name: 'Manager.Customer.View', params: { id: props.customerId }}" class="fw-bold">Перейдите в карточку контрагента</RouterLink> на вкладку "Команда ТП" и добавьте торговых представителей.</p>
                </div>
                <div v-else>
                    <ul class="list-group">
                        <li class="list-group-item m-0">
                            <div class="row text-center align-items-center p-0">
                                <div class="col-5">ФИО</div>
                                <div class="col-2">Продажи, факт</div>
                                <div class="col-2">План, %</div>
                                <div class="col-2">Продажи, план</div>
                                <div class="col-1 text-start">Del</div>
                            </div>
                        </li>
                        <SalesPeopleSupervisorItem
                            v-for="(supervisor, index) in supervisors"
                            :key="supervisor.id"
                            :index="index"
                            :sellers="sellers"
                            :supervisor="supervisor"
                            @add-to-checked-sellers="addToCheckedSellers"
                        />
                        <template
                            v-for="(seller, index) in sellers"
                            :key="seller.id"
                        >
                            <SalesPeopleSellerItem
                                v-if="seller.supervisorId === null"
                                :seller="seller"
                                :index="index"
                                @add-seller="addToCheckedSellers"
                            />
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, reactive, watch } from 'vue';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import { BOOST_SELLER_QUOTIENT, BOOST_SUPERVISOR_QUOTIENT } from '@/helpers/constants.js';
import SalesPeopleSupervisorItem from '@/pages/Promo/SalesPeopleSupervisorItem.vue';
import { formatNumber } from '@/helpers/formatters.js';
import SalesPeopleSellerItem from '@/pages/Promo/SalesPeopleSellerItem.vue';

const { get } = useHttpService();
const arrayHandlers = useArrayHandlers();

const initialFormData = () => ({
    sellerId: '',
    salesBefore: 0,
    salesPlan: 0,
    surplusPlan: 0,
    salesAfter: 0,
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

const supervisors = computed(() => {
    return props.sellers
        .filter(seller => seller.isActive)
        .filter(seller => seller.isSupervisor)
        .map(item => ({
            ...item,
            ...state.form,
            compensation: BOOST_SUPERVISOR_QUOTIENT,
        }));
});

const sellers = computed(() => {
    return props.sellers
        .filter(seller => seller.isActive)
        .filter(seller => !seller.isSupervisor)
        .map(item => ({
            ...item,
            ...state.form,
            compensation: BOOST_SELLER_QUOTIENT,
        }));
});

const addToCheckedSellers = (seller) => {
    const itemIdx = state.checkedSellers.findIndex(ch => ch.id === seller.id);
    if (itemIdx === -1) {
        state.checkedSellers.push(seller);
    } else {
        state.checkedSellers[itemIdx] = { ...seller };
    }
    emit('addSellersToPromo', state.checkedSellers);
};

const totalBudget = computed(() => {
    return state.checkedSellers.reduce((acc, seller) => {
            return acc + parseInt(seller.budgetPlan);
        }, 0);
});

watch(
    () => props.customerId,
    () => {
        state.checkedSellers = [];
    },
);

/*
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
};*/
</script>
