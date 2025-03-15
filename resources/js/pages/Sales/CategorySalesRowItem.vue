<template>
    <tr class="font-monospace">
        <td class="border-end text-end pe-3" style="min-width: 110px;">
            {{ formatNumber(props.item.salesPlan) }}
        </td>
        <td class="border-end px-0" style="min-width: 110px;">
            <TheInput
                class="sales-actual-input text-end"
                :model-value="state.form.salesActual"
                @blur="updateSalesActual"
            />
        </td>
        <td class="border-end text-end pe-3" style="min-width: 130px;">
            <span :class="calcDiffPercentColorInverse(diffPercent)">{{ formatNumberWithFractions(diffPercent) }}</span></td>
        <td class="text-end pe-3" style="min-width: 130px;">{{ formatNumberWithFractions(outputPercent) }}</td>
    </tr>
</template>

<script setup>
import { convertInputStringToNumber, formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';
import TheInput from '@/components/form/TheInput.vue';
import { computed, reactive } from 'vue';
import { useCalculations } from '@/use/useCalculations.js';

const { calcPercentage, calcDiffPercentColorInverse } = useCalculations();

const props = defineProps({
    item: {
        type: Object,
        default: () => {},
    },
});

const emit = defineEmits([
    'updateSalesActual',
]);

const initialFormData = () => ({
    id: props.item.id,
    customerId: props.item.customerId,
    salesActual: props.item.salesActual ? formatNumber(props.item.salesActual) : '',
});

const state = reactive({
    form: initialFormData(),
});

// TODO = попробовать provide-inject
const updateSalesActual = (evt) => {
    const actual = convertInputStringToNumber(evt.target.value);
    if ( isNaN(actual) ) {
        evt.target.value = ''
        state.form.salesActual = '';
    } else {
        evt.target.value = formatNumber(actual);
        if ( props.item.salesActual !== actual ) {
            state.form.salesActual = evt.target.value;
            emit('updateSalesActual', state.form);
        }
    }
};

const outputPercent = computed(() => {
    return calcPercentage(props.item.salesPlan, props.item.salesActual);
});

const diffPercent = computed(() => {
    return outputPercent.value - 100;
});
</script>

