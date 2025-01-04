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
                        В команду дистрибутора не добавлено ни одного торгового представителя.
                        <RouterLink :to="{ name: 'Manager.Customer.View', params: { id: props.customerId }}"
                                    class="fw-bold">Перейдите в карточку контрагента
                        </RouterLink>
                        на вкладку "Команда ТП" и добавьте торговых представителей.
                    </div>
                    <div v-else>
                        <div class="row mb-3">
                            <hr>
                            <p><span class="fw-bold text-primary">Шаг 1.</span> Настройте процент мотивации для
                                супервайзеров и торговых представителей:</p>
                            <div class="col-md-6 col-sm-12">
                                <TheLabel
                                    for="motivation_for_supervisors"
                                >Мотивация СВ: <span class="fw-bold text-primary fs-5">{{
                                        state.motivationForSupervisors
                                    }}&#8239;%</span>
                                </TheLabel>
                                <InputRange
                                    id="motivation_for_supervisors"
                                    v-model="state.motivationForSupervisors"
                                    :max="10"
                                    :min="0"
                                    :step="1"
                                />
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <TheLabel
                                    for="motivation_for_sellers"
                                >Мотивация ТП: <span class="fw-bold text-primary fs-5">{{ state.motivationForSellers }}&#8239;%</span>
                                </TheLabel>
                                <InputRange
                                    id="motivation_for_sellers"
                                    v-model="state.motivationForSellers"
                                    :max="30"
                                    :min="0"
                                    :step="1"
                                />
                            </div>
                        </div>
                        <hr>
                        <p><span class="fw-bold text-primary">Шаг 2.</span> Введите факт и план продаж (в рублях) для
                            торговых представителей, участвующих в акции.</p>
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
                                            :value="formatNumber(totalSalesBefore)"
                                            class="fw-bold border-secondary text-end"
                                            readonly
                                            :tabindex="-1"
                                        />
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <TheInput
                                            class="bg-warning-light"
                                            readonly
                                            :tabindex="-1"
                                        />
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <TheInput
                                            :value="formatNumberWithFractions(totalSalesPlan)"
                                            class="fw-bold border-secondary text-end"
                                            readonly
                                            :tabindex="-1"
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
import { MANAGER_URLS } from '@/helpers/constants.js';
import SalesPeopleSupervisorItem from '@/pages/Promo/SalesPeopleSupervisorItem.vue';
import { formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';
import SalesPeopleSellerItem from '@/pages/Promo/SalesPeopleSellerItem.vue';
import TheInput from '@/components/form/TheInput.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import InputRange from '@/components/form/InputRange.vue';

const { get } = useHttpService();
const arrayHandlers = useArrayHandlers();

const initialFormData = () => ({
    sellerId: '',
    salesBefore: 0,
    salesPlan: 0,
    surplusPlan: 0,
    budgetPlan: 0,
    budgetActual: 0,
    compensationPlan: 0,
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
    motivationForSupervisors: 5,
    motivationForSellers: 10,
    sellers: [],
    checkedSellers: [],
    form: initialFormData(),
});

watch(
    () => props.customerId,
    async (newValue) => {
        state.motivationForSupervisors = 5;
        state.motivationForSellers = 10;
        state.sellers = [];
        state.checkedSellers = [];
        state.form = initialFormData();
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
            compensationPlan: state.motivationForSupervisors,
        }));
});

const sellers = computed(() => {
    return state.sellers
        .filter(seller => seller.isActive)
        .filter(seller => !seller.isSupervisor)
        .map(item => ({
            ...item,
            ...state.form,
            compensationPlan: state.motivationForSellers,
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
        if ( (seller.isSupervisor || seller.supervisorId === null) && !isNaN(seller.salesBefore) ) {
            acc += parseInt(seller.salesBefore);
        }
            return acc;
        }, 0);
});

const totalSalesPlan = computed(() => {
    return state.checkedSellers.reduce((acc, seller) => {
        if ( seller.isSupervisor || seller.supervisorId === null ) {
            acc += seller.salesPlan;
        }
            return acc;
        }, 0);
});

const totalBudgetPlan = computed(() => {
    return state.checkedSellers.reduce((acc, seller) => {
            return acc + parseInt(seller.budgetPlan);
        }, 0);
});
</script>
