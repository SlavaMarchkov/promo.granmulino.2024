<template>
    <div class="row mb-4">
        <div class="col-6">
            <h3 class="mb-1">{{ $route.meta.title }}</h3>
        </div>
        <div class="col-6 text-end">
            <TheButton
                @click="handleClick"
                class="btn-primary"
            >Добавить план
            </TheButton>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <TheFilter
                @reset-filter="clearSearch"
            >
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        v-model="searchBy.year"
                        :chooseFrom="'-- Выберите год --'"
                        :items="state.years"
                        selected-option="year"
                    >Год
                    </SelectGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        :disabled="searchBy.year === '' || searchBy.period !== ''"
                        v-model="searchBy.month"
                        :chooseFrom="'-- Выберите месяц --'"
                        :items="MONTHS"
                        selected-option="month"
                    >Месяц
                    </SelectGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        :disabled="searchBy.year === ''"
                        v-model="searchBy.period"
                        :chooseFrom="'-- Выберите период --'"
                        :items="PERIODS"
                        selected-option="period"
                    >Период года
                    </SelectGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        :disabled="searchBy.year === ''"
                        v-model="searchBy.customerId"
                        :chooseFrom="'-- Выберите название --'"
                        :items="state.customers"
                    >Контрагент
                    </SelectGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        :disabled="searchBy.year === ''"
                        v-model="searchBy.categoryId"
                        :chooseFrom="'-- Выберите группу товаров --'"
                        :items="salesStore.getCategories"
                    >Группа товаров
                    </SelectGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <TheCheckbox
                        id="show_months"
                        v-model="showMonths"
                        :disabled="searchBy.month !== ''"
                    >
                        {{ showMonths ? 'Показать' : 'Скрыть' }} разбивку по месяцам
                    </TheCheckbox>
                </div>
            </TheFilter>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <template v-if="state.sales.length > 0">
                <SalesPlanActualItem
                    v-for="(entry, index) in state.sales"
                    :key="index"
                    :entry="entry"
                    :categories="state.categories"
                    :months="state.months"
                    :period="state.period"
                    :show-months="showMonths"
                    @update-sales-actual="updateSalesActualHandler"
                />
            </template>
            <p v-else class="mt-3 text-center lead">
                {{ spinnerStore.isLoading ? 'Подождите, загружаю...' : 'Записей не найдено. Выберите год для подгрузки планов продаж.' }}
            </p>
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
                        placeholder="Кликните для выбора даты"
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
                        <div class="col-md-5">Группа товаров</div>
                        <div class="col-md-4">План продаж, кг</div>
                        <div class="col-md-3">Доля в плане, %</div>
                    </div>
                </li>
                <SalesPlanItem
                    v-for="category in state.salesPlans"
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
                :disabled="spinnerStore.isButtonDisabled || !isFormValid()"
                :loading="spinnerStore.isButtonDisabled"
                class="btn-success w-25"
                @click="saveSalesPlans"
            >Сохранить</TheButton>
        </template>
    </TheModal>
</template>

<script setup>
import { computed, onMounted, reactive, ref, watch } from 'vue';
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
import { INITIALS, MANAGER_URLS, MONTHS, PERIODS } from '@/helpers/constants.js';
import SalesPlanItem from '@/pages/Sales/SalesPlanItem.vue';
import SalesPlanActualItem from '@/pages/Sales/SalesPlanActualItem.vue';
import Alert from '@/components/Alert.vue';
import { useAuthStore } from '@/stores/auth.js';
import { useSalesStore } from '@/stores/sales.js';
import TheFilter from '@/components/core/TheFilter.vue';
import SelectGroup from '@/components/form/SelectGroup.vue';
import TheCheckbox from '@/components/form/TheCheckbox.vue';

const authUser = useAuthStore().getUser;
const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const salesStore = useSalesStore();
const arrayHandlers = useArrayHandlers();
const { get, post, update } = useHttpService();

const modals = reactive({
    addModalPopUp: false,
});

const showMonths = ref(false);

const isFormValid = () => {
    return state.form.salesDate !== '' && state.form.customerId !== '';
};

const initialFormData = () => ({
    userId: authUser.id,
    salesDate: '',
    customerId: '',
});

const state = reactive({
    customers: [],
    categories: [],
    sales: [],
    years: [],
    salesPlans: [],
    months: MONTHS,
    period: INITIALS.PERIOD,
    form: initialFormData(),
});

onMounted(async () => {
    await getCustomers();
    await getSalesYears();
    await getCategories().then(() => state.salesPlans = generateSalesPlans([]));
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
    state.customers = arrayHandlers.sortArrayByStringColumn(data.customers, 'name');
};

const getCategories = async () => {
    const { data } = await get(MANAGER_URLS.CATEGORY, {
        params: {
            products: false,
        },
    });
    salesStore.setCategories(data.categories);
    state.categories = salesStore.getCategories;
};

const getSalesYears = async () => {
    const { data } = await get(`${ MANAGER_URLS.SALES }/getSalesYears`);
    state.years = Array.from(JSON.parse(data)).map(year => ({
        id: year,
        year: year.toString(),
    }));
};

const getSales = async (year) => {
    const { data } = await get(MANAGER_URLS.SALES, {
        params: {
            year,
        },
    });
    salesStore.setSales(JSON.parse(data));
    state.sales = arrayHandlers.sortArrayByStringColumn(salesStore.getSales, 'customerName');
};

const getSalesPlans = async (year, month, customerId) => {
    const { data } = await get(`${ MANAGER_URLS.CUSTOMER }/${ customerId }${ MANAGER_URLS.SALES }`, {
        params: {
            year,
            month,
        },
    });
    const salesArr = JSON.parse(data).filter(item => item.customerId === customerId)[0].sales.data;
    const salesPlansPerMonth = salesArr.length === 0 ? [] : salesArr[month];
    state.salesPlans = generateSalesPlans(salesPlansPerMonth);
};

const searchBy = reactive({
    year: '',
    month: '',
    period: '',
    customerId: '',
    categoryId: '',
});

watch(
    () => searchBy.year,
    (current) => {
        searchBy.month = '';
        searchBy.period = '';
        searchBy.customerId = '';
        searchBy.categoryId = '';

        if ( current ) {
            getSales(current);
        } else {
            salesStore.setSales([]);
            state.sales = salesStore.getSales;
        }
    },
);

watch(
    () => searchBy.categoryId,
    (current) => state.categories = current
        ? salesStore.getCategories.filter(category => +category.id === +current)
        : salesStore.getCategories,
);

watch(
    () => searchBy.customerId,
    (current) => state.sales = current
        ? salesStore.getSales.filter(item => item.customerId === +current)
        : arrayHandlers.sortArrayByStringColumn(salesStore.getSales, 'customerName'),
);

watch(
    () => searchBy.month,
    (current) => {
        state.months = current ? MONTHS.filter(month => month.id === current) : MONTHS;
        showMonths.value = false;
    }
);

watch(
    () => searchBy.period,
    (current) => {
        searchBy.month = '';

        const idx = PERIODS.findIndex(p => p.id === current);
        state.period = idx !== -1 ? PERIODS[idx].period : INITIALS.PERIOD;

        const slicer = current.split('-');
        state.months = MONTHS.slice(slicer[0], slicer[1]);
        state.sales = arrayHandlers.sortArrayByStringColumn(
            generateSalesForPeriod(state.months),
            'customerName',
        );
        if ( searchBy.customerId ) {
            state.sales = state.sales.filter(item => item.customerId === +searchBy.customerId);
        }
    },
);

watch(
    () => state.form.salesDate,
    (current) => {
        if ( current ) {
            const year = new Date(current).getFullYear();
            const monthIdx = new Date(current).getMonth();
            const month = MONTHS[monthIdx].id;
            const customerId = state.form.customerId;
            if (customerId) {
                getSalesPlans(year, month, customerId);
            }
        }
    },
);

watch(
    () => state.form.customerId,
    (current) => {
        const salesDate = state.form.salesDate;
        if ( salesDate ) {
            const year = new Date(salesDate).getFullYear();
            const monthIdx = new Date(salesDate).getMonth();
            const month = MONTHS[monthIdx].id;
            const customerId = current;
            if (customerId) {
                getSalesPlans(year, month, customerId);
            }
        }
    },
);

const clearSearch = () => {
    arrayHandlers.resetSearchKeys(searchBy);
    state.form = initialFormData();
    state.months = MONTHS;
    state.period = INITIALS.PERIOD;
    showMonths.value = false;
};

const handleClick = () => {
    modals.addModalPopUp = true;
    alertStore.clear();
    state.form = initialFormData();
    state.salesPlans.forEach(sp => sp.salesPlan = 0);
};

const saveSalesPlans = async () => {
    const form = {
        ...state.form,
        salesPlans: state.salesPlans.filter(sp => sp.salesPlan !== 0),
    };
    const customerId = state.form.customerId;
    const year = new Date(form.salesDate).getFullYear().toString();
    const monthIdx = new Date(form.salesDate).getMonth();
    const month = MONTHS[monthIdx].id;
    const response = await post(`${ MANAGER_URLS.CUSTOMER }/${ customerId }${ MANAGER_URLS.SALES }`, form);
    if ( response && response.status === 'success' ) {
        const responseData = response.data.data[month];
        alertStore.clear();
        if ( !isYearExists(year) ) {
            await getSalesYears();
        }
        searchBy.year = year;
        const idx = salesStore.getSales.findIndex(s => s.customerId === customerId);
        if (idx !== -1) {
            const salesData = salesStore.getSales[idx].sales.data[month];

            // если план на месяц добавляется первый раз
            if ( salesData === undefined ) {
                salesStore.getSales[idx].sales.data = {
                    ...salesStore.getSales[idx].sales.data,
                    [month]: responseData,
                };
                return;
            }

            const salesDataCats = [];
            let salesPlanCats = [];
            salesData.forEach(sd => {
                salesDataCats.push(sd.categoryId);
                form.salesPlans.forEach(sp => {
                    salesPlanCats.push(sp.categoryId);
                    if ( sd.categoryId === sp.categoryId ) sd.salesPlan = sp.salesPlan;
                });
            });
            salesPlanCats = [...new Set(salesPlanCats)]; // удаляем дубли

            // если в плане меньше категорий, чем в store
            salesDataCats
                .filter(sp => salesPlanCats.indexOf(sp) === -1)
                .forEach(categoryId => {
                    const idx = salesData.findIndex(sd => sd.categoryId === categoryId);
                    salesData.splice(idx, 1);
                });

            // если в store меньше категорий, чем в плане
            salesPlanCats
                .filter(sp => salesDataCats.indexOf(sp) === -1)
                .forEach(el => responseData.forEach(data => {
                    if ( data.categoryId === el ) salesData.push(data);
                }));
        }
    }
};

const updateSalesActualHandler = async (item) => {
    const {
        status,
        data,
    } = await update(`${ MANAGER_URLS.CUSTOMER }/${ item.customerId }${ MANAGER_URLS.SALES }/${ item.id }`, item);
    if ( status === 'success' ) {
        const idx = salesStore.getSales.findIndex(s => s.customerId === data.customerId);
        const el = salesStore.getSales[idx].sales.data[data.salesMonth].find(sd => sd.id === item.id);
        el.salesActual = convertInputStringToNumber(data.salesActual);
        state.sales = searchBy.customerId
            ? salesStore.getSales.filter(s => s.customerId === +searchBy.customerId)
            : arrayHandlers.sortArrayByStringColumn(salesStore.getSales, 'customerName');
    }
};

const addItemToSalesPlan = (item) => {
    const idx = state.salesPlans.findIndex(sp => sp.categoryId === item.categoryId);
    state.salesPlans[idx].salesPlan = (item.salesPlan !== '')
        ? convertInputStringToNumber(item.salesPlan)
        : state.salesPlans[idx].salesPlan = 0;
};

const totalSalesPlan = computed(() => {
    return state.salesPlans.reduce((acc, item) => {
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

function isYearExists(year) {
    const idx = state.years.findIndex(sy => sy.year === year);
    return idx !== -1;
}

function generateSalesForPeriod(period) {
    return salesStore.getSales.map(item => {
        return {
            customerId: item.customerId,
            customerName: item.customerName,
            sales: {
                data: makeSalesDataObject(item.sales.data, period),
            },
        }
    });
}

function makeSalesDataObject(dataObj, period) {
    let obj = {};
    Object.keys(period).forEach(key => {
        Object.keys(dataObj).forEach(el => {
            if ( period[key].id === el ) {
                obj[el] = dataObj[el];
            }
        });
    });
    return obj;
}

function generateSalesPlans(salesArr) {
    return salesStore.getCategories.map(category => {
        return {
            categoryId: category.id,
            name: category.name,
            salesPlan: makeCategorySalesPlan(category.id, salesArr),
        };
    });
}

function makeCategorySalesPlan(categoryId, salesArr) {
    let plan = 0;
    if ( salesArr.length > 0 ) {
        salesArr.forEach(salesPlan => {
            if (categoryId === salesPlan.categoryId) {
                plan = salesPlan.salesPlan;
            }
        });
    }
    return plan;
}
</script>
