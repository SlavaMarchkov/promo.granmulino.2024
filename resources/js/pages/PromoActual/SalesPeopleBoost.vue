<template>
    <div class="row flex-column g-3">
        <p class="mb-0">Введите фактическое выполнение плана продаж (в рублях) для
            торговых представителей, участвующих в акции.</p>
        <ul class="list-group">
            <li class="list-group-item m-0 px-2">
                <div class="row g-2 text-center align-items-center p-0">
                    <div class="col-md-3 col-sm-12">ФИО</div>
                    <div class="col-md-4 col-sm-12">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">Продажи "До"</div>
                            <div class="col-md-4 col-sm-6">Продажи, план</div>
                            <div class="col-md-4 col-sm-6">Продажи, факт</div>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">Выполнение, %</div>
                            <div class="col-md-3 col-sm-6">Мотивация, %</div>
                            <div class="col-md-3 col-sm-6">Бюджет, план</div>
                            <div class="col-md-3 col-sm-6">Бюджет, факт</div>
                        </div>
                    </div>
                </div>
            </li>
            <SalesPeopleSupervisorItem
                v-for="(supervisor, index) in supervisors"
                :key="supervisor.id"
                :index="index"
                :sellers="sellers"
                :supervisor="supervisor"
                @update-supervisor="updateSupervisor"
            />
            <template
                v-for="(seller, index) in sellers"
                :key="seller.id"
            >
                <SalesPeopleSellerItem
                    v-if="seller.supervisorId === null"
                    :seller="seller"
                    :index="index"
                />
            </template>
            <li class="list-group-item m-0 px-2 bg-warning-light">
                <div class="row text-center align-items-center">
                    <div class="col-md-3 col-sm-12"><span class="fw-bold">ИТОГО</span></div>
                    <div class="col-md-4 col-sm-12">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <TheInput
                                    v-model="state.promo.totalSalesBefore"
                                    class="fw-bold border-secondary text-end"
                                    readonly
                                    :tabindex="-1"
                                />
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <TheInput
                                    v-model="state.promo.totalSalesPlan"
                                    class="fw-bold border-secondary text-end"
                                    readonly
                                    :tabindex="-1"
                                />
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <TheInput
                                    v-model="state.promo.totalSalesAfter"
                                    class="fw-bold border-secondary text-end"
                                    readonly
                                    :tabindex="-1"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <TheInput
                                    class="fw-bold border-secondary text-end"
                                    :model-value="calcTotalSalesDiff"
                                    readonly
                                    :tabindex="-1"
                                />
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <TheInput
                                    class="bg-warning-light"
                                    readonly
                                    :tabindex="-1"
                                />
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <TheInput
                                    v-model="state.promo.totalBudgetPlan"
                                    class="fw-bold border-secondary text-end"
                                    readonly
                                    :tabindex="-1"
                                />
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <TheInput
                                    v-model="state.promo.totalBudgetActual"
                                    class="fw-bold border-primary text-end"
                                    readonly
                                    :tabindex="-1"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { computed, nextTick, reactive } from 'vue';
import SalesPeopleSupervisorItem from '@/pages/PromoActual/SalesPeopleSupervisorItem.vue';
import { convertInputStringToNumber, formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';
import TheInput from '@/components/form/TheInput.vue';
import SalesPeopleSellerItem from '@/pages/Promo/SalesPeopleSellerItem.vue';
import { useCalculations } from '@/use/useCalculations.js';

const { calcPercentage } = useCalculations();

const props = defineProps({
    items: {
        type: Array,
        default: () => [],
    },
    promo: {
        type: Object,
        required: true,
        default: () => {},
    },
});

const emit = defineEmits([
    'updatePromoSellers',
]);

const initialFormData = () => ({
    id: props.promo.id,
    totalSalesBefore: formatNumber(props.promo.totalSalesBefore),
    totalSalesPlan: formatNumber(props.promo.totalSalesPlan),
    totalSalesAfter: formatNumber(props.promo.totalSalesAfter),
    totalBudgetPlan: formatNumberWithFractions(props.promo.totalBudgetPlan),
    totalBudgetActual: formatNumberWithFractions(props.promo.totalBudgetActual),
});

const state = reactive({
    promo: initialFormData(),
});

const supervisors = computed(() => props.items.filter(seller => seller.isSupervisor));

const sellers = computed(() => props.items.filter(seller => !seller.isSupervisor));

const updateSeller = (seller) => {
    const itemIdx = sellers.value.findIndex(item => item.id === seller.id);
    sellers.value[itemIdx] = seller;
};

const updateSupervisor = (supervisor, seller) => {
    const itemIdx = supervisors.value.findIndex(item => item.id === supervisor.id);
    supervisors.value[itemIdx] = supervisor;

    updateSeller(seller);

    nextTick(() => {
        state.promo.totalSalesAfter = formatNumber(totalSalesAfter());
        state.promo.totalBudgetActual = formatNumberWithFractions(totalBudgetActual());
    });

    const mergedArray = supervisors.value.concat(sellers.value);

    emit('updatePromoSellers', state.promo, mergedArray);
};

const totalSalesAfter = () => {
    return supervisors.value.reduce((acc, supervisor) => {
        if ( (supervisor.isSupervisor || supervisor.supervisorId === null) && isNaN(supervisor.salesAfter) ) {
            const salesAfter = convertInputStringToNumber(supervisor.salesAfter);
            acc += salesAfter;
        }
        return acc;
    }, 0);
};

const calcTotalSalesDiff = computed(() => {
    if ( state.promo.totalSalesAfter !== 0 ) {
        const result = calcPercentage(state.promo.totalSalesPlan, state.promo.totalSalesAfter);
        return formatNumberWithFractions(result);
    } else {
        return formatNumberWithFractions(0);
    }
});

const totalBudgetActual = () => {
    const supervisorsTotalBudgetActual = supervisors.value.reduce((acc, supervisor) => {
        return acc + convertInputStringToNumber(supervisor.budgetActual.toString());
    }, 0);

    const sellersTotalBudgetActual = sellers.value.reduce((acc, seller) => {
        return acc + convertInputStringToNumber(seller.budgetActual.toString());
    }, 0);

    return supervisorsTotalBudgetActual + sellersTotalBudgetActual;
};
</script>
