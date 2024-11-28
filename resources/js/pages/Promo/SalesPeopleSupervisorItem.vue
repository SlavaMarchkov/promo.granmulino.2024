<template>
    <li class="list-group-item m-0 px-2">
        <div class="row g-2">
            <div class="col-md-5 col-sm-12">
                <div class="input-group">
                    <span class="input-group-text">{{ index + 1 }}</span>
                    <input
                        :value="props.supervisor.shortName"
                        class="form-control fw-bold"
                        readonly
                        type="text"
                    >
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <TheInput
                    :id="`${props.supervisor.id}_SV_salesBefore`"
                    class="text-end"
                    type="text"
                    readonly
                />
            </div>
            <div class="col-md-2 col-sm-6">
                <TheInput disabled="disabled" />
            </div>
            <div class="col-md-2 col-sm-6">
                <TheInput
                    :id="`${props.supervisor.id}_SV_salesPlan`"
                    class="text-end"
                    type="text"
                    readonly
                />
            </div>
            <div class="col-md-1 col-sm-6 text-center"></div>
        </div>
    </li>
    <template
        v-for="(seller, index) in props.sellers"
        :key="seller.id"
    >
        <SalesPeopleSellerItem
            v-if="seller.supervisorId === props.supervisor.id"
            :seller="seller"
            :index="index"
            @add-seller="addSeller"
        />
    </template>
</template>

<script setup>
import SalesPeopleSellerItem from '@/pages/Promo/SalesPeopleSellerItem.vue';
import TheInput from '@/components/form/TheInput.vue';
import { computed, reactive } from 'vue';
import { formatNumber } from '@/helpers/formatters.js';
import { BOOST_SUPERVISOR_QUOTIENT } from '@/helpers/constants.js';

const props = defineProps({
    supervisor: {
        type: Object,
        required: true,
    },
    index: {
        type: Number,
        default: 1,
    },
    sellers: {
        type: Array,
        required: true,
        default: () => [],
    },
});

const emit = defineEmits([
    'addToCheckedSellers',
]);

const state = reactive({
    sellers: [],
});

const addSeller = (seller) => {
    emit('addToCheckedSellers', seller);

    let supervisorObj = props.supervisor;
    console.log(supervisorObj);

    const itemIdx = state.sellers.findIndex(ss => ss.id === seller.id);

    if (itemIdx === -1) {
        state.sellers.push(seller);
    } else {
        state.sellers[itemIdx] = { ...seller };
    }

    const salesBeforeEl = document.getElementById(`${props.supervisor.id}_SV_salesBefore`);
    const salesPlanEl = document.getElementById(`${props.supervisor.id}_SV_salesPlan`);

    salesBeforeEl.value = formatNumber(salesBefore.value);
    salesPlanEl.value = formatNumber(salesPlan.value);

    supervisorObj.sellerId = supervisorObj.id;
    supervisorObj.salesBefore = salesBefore;
    supervisorObj.salesPlan = salesPlan;
    supervisorObj.budgetPlan = budgetPlan;

    emit('addToCheckedSellers', supervisorObj);
};

const salesBefore = computed(() => {
    return state.sellers.reduce((acc, el) => {
        return acc + el.salesBefore;
    }, 0);
});

const salesPlan = computed(() => {
    return state.sellers.reduce((acc, el) => {
        return acc + el.salesPlan;
    }, 0);
});

const budgetPlan = computed(() => {
   return +(salesPlan.value * BOOST_SUPERVISOR_QUOTIENT / 100).toFixed(2);
});
</script>
