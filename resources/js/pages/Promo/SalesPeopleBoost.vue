<template>
    <div>
        <div class="card">
            <div class="card-header bg-secondary text-white">{{ props.title }}</div>
            <div class="card-body mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Планируемый бюджет на промо-акцию:</h4>
                    <h4 class="text-primary fw-bold mb-0">{{ isNaN(totalBudgetPlan) ? '0' : formatNumber(totalBudgetPlan) }} руб.</h4>
                </div>
                <hr>
                <h5>Мотивация для расчёта бюджета: <span class="fw-bold text-primary">
                    СВ: {{ BOOST_SUPERVISOR_QUOTIENT }}&#8239;% ТП: {{ BOOST_SELLER_QUOTIENT }}&#8239;%</span>
                </h5>
                <div v-if="!props.customerId" class="mt-5 alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Выберите дистрибутора в общих настройках промо-акции для подгрузки его торгового персонала.
                </div>
                <template v-else>
                    <div class="mt-3 alert border-primary fade show" role="alert">
                        <h5 class="mb-0">Дистрибутор: <span class="fw-bold text-primary">{{ props.customerName }}</span></h5>
                    </div>
                    <div v-if="state.sellers.length === 0" class="mt-4 alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        В команду дистрибьютора не добавлено ни одного торгового представителя. <RouterLink :to="{ name: 'Manager.Customer.View', params: { id: props.customerId }}" class="fw-bold">Перейдите в карточку контрагента</RouterLink> на вкладку "Команда ТП" и добавьте торговых представителей.
                    </div>
                    <div v-else>
                        <p>Введите план для торговых представителей, участвующих в акции.</p>
                        <ul class="list-group">
                            <li class="list-group-item m-0 px-2">
                                <div class="row g-2 text-center align-items-center p-0">
                                    <div class="col-md-5 col-sm-12">ФИО</div>
                                    <div class="col-md-2 col-sm-6">Продажи, факт</div>
                                    <div class="col-md-2 col-sm-6">План, %</div>
                                    <div class="col-md-2 col-sm-6">Продажи, план</div>
                                    <div class="col-md-1 col-sm-6">Del</div>
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
                            <li class="list-group-item m-0 px-2 bg-warning-light">
                                <div class="row g-2 text-center align-items-center p-0">
                                    <div class="col-md-5 col-sm-12"><span class="fw-bold">ИТОГО</span></div>
                                    <div class="col-md-2 col-sm-6">
                                        <TheInput
                                            :value="isNaN(totalSalesBefore) ? '' : formatNumber(totalSalesBefore)"
                                            class="fw-bold border-secondary text-end"
                                            type="text"
                                            readonly
                                        />
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <TheInput disabled="disabled" />
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <TheInput
                                            :value="formatNumberWithFractions(totalSalesPlan)"
                                            class="fw-bold border-secondary text-end"
                                            type="text"
                                            readonly
                                        />
                                    </div>
                                    <div class="col-md-1 col-sm-6"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, reactive, watch } from 'vue';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import { BOOST_SELLER_QUOTIENT, BOOST_SUPERVISOR_QUOTIENT, MANAGER_URLS } from '@/helpers/constants.js';
import SalesPeopleSupervisorItem from '@/pages/Promo/SalesPeopleSupervisorItem.vue';
import { formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';
import SalesPeopleSellerItem from '@/pages/Promo/SalesPeopleSellerItem.vue';
import TheInput from '@/components/form/TheInput.vue';

const { get } = useHttpService();
const arrayHandlers = useArrayHandlers();

const initialFormData = () => ({
    sellerId: '',
    salesBefore: 0,
    salesPlan: 0,
    surplusPlan: 0,
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
        type: [Number, String],
        required: true,
    },
    customerName: {
        type: String,
        default: '',
    },
});

const emit = defineEmits([
   'addSellersToPromo',
]);

const state = reactive({
    sellers: [],
    checkedSellers: [],
    form: initialFormData(),
});

watch(
    () => props.customerId,
    async (newValue) => {
        state.sellers = [];
        state.checkedSellers = [];
        if ( newValue !== '' ) await getCustomerSellers(newValue);
    },
);

const getCustomerSellers = async (customerId) => {
    const { status, data } = await get(`${MANAGER_URLS.CUSTOMER}/${customerId}`, {
        params: {
            'customer_sellers': true,
        },
    });
    if ( status === 'success' ) state.sellers = data.sellers;
};

const supervisors = computed(() => {
    return state.sellers
        .filter(seller => seller.isActive)
        .filter(seller => seller.isSupervisor)
        .map(item => ({
            ...item,
            ...state.form,
            compensation: BOOST_SUPERVISOR_QUOTIENT,
        }));
});

const sellers = computed(() => {
    return state.sellers
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

    emit('addSellersToPromo',
        state.checkedSellers,
        totalSalesBefore.value,
        totalSalesPlan.value,
        totalBudgetPlan.value,
    );
};

const totalSalesBefore = computed(() => {
    return state.checkedSellers.reduce((acc, seller) => {
            if (seller.isSupervisor || seller.supervisorId === null) acc += parseInt(seller.salesBefore);
            return acc;
        }, 0);
});

const totalSalesPlan = computed(() => {
    return state.checkedSellers.reduce((acc, seller) => {
            if (seller.isSupervisor || seller.supervisorId === null) acc += seller.salesPlan;
            return acc;
        }, 0);
});

const totalBudgetPlan = computed(() => {
    return state.checkedSellers.reduce((acc, seller) => {
            return acc + parseInt(seller.budgetPlan);
        }, 0);
});
</script>
