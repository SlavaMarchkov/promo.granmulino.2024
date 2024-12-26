<template>
    <li class="list-group-item m-0 px-2">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <div class="input-group">
                    <span class="input-group-text">{{ index + 1 }}</span>
                    <input
                        :value="props.supervisor.name"
                        class="form-control fw-bold"
                        readonly
                        type="text"
                        tabindex="-1"
                    >
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <TheInput
                            class="fw-bold border-primary text-end"
                            :model-value="state.supervisor.salesBefore"
                            readonly
                            :tabindex="-1"
                        />
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <TheInput
                            class="fw-bold border-primary text-end"
                            :model-value="state.supervisor.salesPlan"
                            readonly
                            :tabindex="-1"
                        />
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <TheInput
                            class="fw-bold border-primary text-end"
                            v-model="state.supervisor.salesAfter"
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
                            class="fw-bold border-primary text-end"
                            :model-value="calcSalesDiff"
                            readonly
                            :tabindex="-1"
                        />
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <TheInput
                            class="fw-bold border-primary text-end"
                            :model-value="state.supervisor.compensationPlan"
                            readonly
                            :tabindex="-1"
                        />
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <TheInput
                            class="fw-bold border-primary text-end"
                            :model-value="state.supervisor.budgetPlan"
                            readonly
                            :tabindex="-1"
                        />
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <TheInput
                            class="fw-bold border-primary text-end"
                            v-model="state.supervisor.budgetActual"
                            readonly
                            :tabindex="-1"
                        />
                    </div>
                </div>
            </div>
        </div>
    </li>
    <template
        v-for="(seller, index) in props.sellers"
        :key="seller.id"
    >
        <SalesPeopleSellerItem
            v-if="seller.supervisorId === props.supervisor.sellerId"
            :seller="seller"
            :index="index"
            @update-seller="updateSeller"
        />
    </template>
</template>

<script setup>
import { computed, reactive, ref } from 'vue';
import TheInput from '@/components/form/TheInput.vue';
import SalesPeopleSellerItem from '@/pages/PromoActual/SalesPeopleSellerItem.vue';
import { convertInputStringToNumber, formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';
import { useCalculations } from '@/use/useCalculations.js';

const { calcPercentage } = useCalculations();

const props = defineProps({
    supervisor: {
        type: Object,
        required: true,
    },
    index: {
        type: Number,
        default: 0,
    },
    sellers: {
        type: Array,
        required: true,
        default: () => [],
    },
});

const initialFormData = () => ({
    id: props.supervisor.id,
    sellerId: props.supervisor.sellerId,
    supervisorId: props.supervisor.supervisorId,
    isSupervisor: props.supervisor.isSupervisor,
    salesBefore: formatNumber(props.supervisor.salesBefore),
    salesPlan: formatNumber(props.supervisor.salesPlan),
    salesAfter: formatNumber(props.supervisor.salesAfter),
    compensationPlan: props.supervisor.compensationPlan,
    compensationActual: props.supervisor.compensationActual,
    budgetPlan: formatNumberWithFractions(props.supervisor.budgetPlan),
    budgetActual: formatNumberWithFractions(props.supervisor.budgetActual),
});

const state = reactive({
    supervisor: initialFormData(),
});

const sellers = ref([]);

const updateSeller = (seller) => {
    const itemIdx = sellers.value.findIndex(item => item.id === seller.id);

    if (itemIdx === -1) {
        sellers.value.push(seller);
    } else {
        sellers.value[itemIdx] = { ...seller };
    }

    state.supervisor.salesAfter = formatNumber(calcSalesAfter());
    state.supervisor.budgetActual = formatNumberWithFractions(calcBudgetActual());
};

const calcSalesAfter = () => {
    return sellers.value.reduce((acc, el) => {
        if ( !isNaN(el.salesAfter) ) {
            return +(acc + el.salesAfter).toFixed(0);
        }
    }, 0);
};

const calcSalesDiff = computed(() => {
    if ( state.supervisor.salesAfter !== 0 ) {
        const result = calcPercentage(state.supervisor.salesPlan, state.supervisor.salesAfter);
        return formatNumberWithFractions(result);
    } else {
        return formatNumberWithFractions(0);
    }
});

const calcBudgetActual = () => {
    const boostSupervisorQuotient = convertInputStringToNumber(state.supervisor.compensationPlan.toString());
    const salesAfter = convertInputStringToNumber(state.supervisor.salesAfter);
    return (salesAfter * boostSupervisorQuotient / 100).toFixed(2);
};
</script>
