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
                <div class="row g-2 text-center align-items-center p-0">
                    <div class="col-md-3 col-sm-12"><span class="fw-bold">ИТОГО</span></div>
                    <div class="col-md-4 col-sm-12">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <TheInput
                                    :value="formatNumber(totalSalesBefore)"
                                    class="fw-bold border-secondary text-end"
                                    readonly
                                />
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <TheInput
                                    :value="formatNumber(totalSalesPlan)"
                                    class="fw-bold border-secondary text-end"
                                    readonly
                                />
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <TheInput
                                    :value="formatNumber(totalSalesActual)"
                                    class="fw-bold border-secondary text-end"
                                    readonly
                                />
                            </div>
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
        </ul>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import SalesPeopleSupervisorItem from '@/pages/PromoActual/SalesPeopleSupervisorItem.vue';
import { formatNumber } from '@/helpers/formatters.js';
import TheInput from '@/components/form/TheInput.vue';
import SalesPeopleSellerItem from '@/pages/Promo/SalesPeopleSellerItem.vue';

const props = defineProps({
    items: {
        type: Array,
        default: () => [],
    },
    promoId: {
        type: Number,
        required: true,
    },
});

const supervisors = computed(() => props.items.filter(seller => seller.isSupervisor));
const sellers = computed(() => props.items.filter(seller => !seller.isSupervisor));

const totalSalesBefore = computed(() => {
    return supervisors.value.reduce((acc, seller) => {
        if ( (seller.isSupervisor || seller.supervisorId === null) && !isNaN(seller.salesBefore) ) {
            acc += parseInt(seller.salesBefore);
        }
        return acc;
    }, 0);
});

const totalSalesPlan = computed(() => {
    return supervisors.value.reduce((acc, seller) => {
        if ( (seller.isSupervisor || seller.supervisorId === null) && !isNaN(seller.salesPlan) ) {
            acc += parseInt(seller.salesPlan);
        }
        return acc;
    }, 0);
});

const totalSalesActual = computed(() => {
    return supervisors.value.reduce((acc, seller) => {
        if ( (seller.isSupervisor || seller.supervisorId === null) && !isNaN(seller.salesActual) ) {
            acc += parseInt(seller.salesActual);
        }
        return acc;
    }, 0);
});
</script>
