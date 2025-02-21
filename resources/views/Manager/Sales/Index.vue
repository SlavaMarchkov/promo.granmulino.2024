<template>
    <div class="row mb-4">
        <div class="col-6">
            <h3 class="mb-1">{{ $route.meta.title }}</h3>
        </div>
        <div class="col-6 text-end">
            <TheButton
                @click="modals.addModalPopUp = true; state.form = initialFormData();"
                class="btn-primary"
            >Добавить план
            </TheButton>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-0">
                    Мои продажи (план-факт) (в разработке...)
<pre>{{ salesPlans }}</pre>
                </div>
            </div>
        </div>
    </div>
    <TheModal
        v-if="modals.addModalPopUp"
        v-model="modals.addModalPopUp"
        id="addModalPopUp"
        :custom-classes="['modal-lg']"
    >
        <template #title>
            Добавление плана продаж
        </template>
        <template #body>
            <Alert/>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <TheLabel for="sales_date" required>Месяц и год</TheLabel>
                    <TheInput
                        id="sales_date"
                        type="text"
                        readonly="readonly"
                    />
                </div>
                <div class="col-md-6">
                    <TheLabel for="customer_id" required>Контрагент</TheLabel>
                    <select
                        v-model="state.form.customerId"
                        id="customer_id"
                        class="form-select"
                    >
                        <option disabled selected value="">-- Выберите дистрибутора --</option>
                        <option
                            v-for="customer in state.customers"
                            :key="customer.id"
                            :value="customer.id"
                        >{{ customer.name }}
                        </option>
                    </select>
                </div>
            </div>
            <ul class="list-group">
                <li class="list-group-item m-0">
                    <div class="row g-2 text-center fw-bold align-items-center p-0">
                        <div class="col-md-5">Группа товара</div>
                        <div class="col-md-4">План продаж, кг</div>
                        <div class="col-md-3">Доля в плане, %</div>
                    </div>
                </li>
                <SalesPlanItem
                    v-for="category in state.categories"
                    :key="category.id"
                    :category="category"
                    :total-sales-plan="totalSalesPlan"
                    @update-sales-plan="addItemToSalesPlan"
                />
                <li class="list-group-item m-0 px-2">
                    <div class="row g-2 text-center align-items-center p-0">
                        <div class="col-md-5"><span class="fw-bold">ИТОГО</span></div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text">кг</span>
                                <TheInput
                                    :value="formatNumber(totalSalesPlan)"
                                    class="fw-bold text-center"
                                    readonly
                                    :tabindex="-1"
                                />
                                <span class="input-group-text">00</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <TheInput
                                    class="fw-bold text-center"
                                    model-value="100,00"
                                    readonly="readonly"
                                    :tabindex="-1"
                                />
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </template>
        <template #footer>
            <TheButton
                :disabled="spinnerStore.isButtonDisabled"
                :loading="spinnerStore.isButtonDisabled"
                class="btn-success w-25"
                @click="saveSalesPlan"
            >Сохранить</TheButton>
        </template>
    </TheModal>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import TheButton from '@/components/core/TheButton.vue';
import TheModal from '@/components/TheModal.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import TheInput from '@/components/form/TheInput.vue';
import { convertInputStringToNumber, formatDateToISO, formatNumber } from '@/helpers/formatters.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import { useHttpService } from '@/use/useHttpService.js';
import { useDatepicker } from 'vue-air-datepicker';
import localeRu from 'air-datepicker/locale/ru';
import { MANAGER_URLS } from '@/helpers/constants.js';
import SalesPlanItem from '@/pages/Sales/SalesPlanItem.vue';
import Alert from '@/components/Alert.vue';
import { useAuthStore } from '@/stores/auth.js';

const authUser = useAuthStore().getUser;
const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();
const { get, post } = useHttpService();

const modals = reactive({
    addModalPopUp: false,
});

const initialFormData = () => ({
    userId: authUser.id,
    salesDate: '',
    customerId: '',
    salesPlan: [],
});

const state = reactive({
    customers: [],
    categories: [],
    form: initialFormData(),
});

const salesPlans = ref([]);

onMounted(async () => {
    await getCustomers();
    await getCategories();
});

const getCustomers = async () => {
    const { data } = await get(MANAGER_URLS.CUSTOMER, {
        params: {
            city:      false,
            region:    false,
            user:      false,
            retailers: false,
        },
    });
    state.customers = data.customers;
};

const getCategories = async () => {
    const { data } = await get(MANAGER_URLS.CATEGORY, {
        params: {
            products: false,
        },
    });
    state.categories = data.categories;
};

const saveSalesPlan = async () => {
    const response = await post(MANAGER_URLS.SALES, state.form);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        salesPlans.value = response.data;
    }
};

const addItemToSalesPlan = (item) => {
    const idx = state.form.salesPlan.findIndex(sp => sp.categoryId === item.categoryId);
    if ( idx === -1 ) {
        if (item.salesPlan !== '') state.form.salesPlan.push(item);
    } else {
        if (item.salesPlan !== '') state.form.salesPlan[idx] = item;
        else state.form.salesPlan.splice(idx, 1);
    }
};

const totalSalesPlan = computed(() => {
    return state.form.salesPlan.reduce((acc, item) => {
        return acc + convertInputStringToNumber(item.salesPlan);
    }, 0);
});

const observer = new MutationObserver((mutations_list) => {
    mutations_list.forEach((mutation) => {
        mutation.addedNodes.forEach((added_node) => {
            if ( added_node.id === 'addModalPopUp' ) {
                useDatepicker('#sales_date', {
                    autoClose: true,
                    locale: localeRu,
                    view: 'months',
                    minView: 'months',
                    onSelect: ({ date, datepicker }) => {
                        state.form.salesDate = formatDateToISO(date);
                        datepicker.hide();
                    },
                });
                const picker = document.querySelector('.air-datepicker-global-container');
                picker.style.zIndex = 10_000;
            }
        });
    });
});

observer.observe(document.querySelector("#app"), {
    subtree: true,
    childList: true,
});
</script>
