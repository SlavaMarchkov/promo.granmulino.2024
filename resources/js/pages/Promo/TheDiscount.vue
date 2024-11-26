<template>
    <div>
        <div class="card">
            <div class="card-header bg-success text-white">{{ props.title }}</div>
            <div class="card-body mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Ассортимент для промо-акции</span>
                    <TheButton
                        @click="addProductModalInit"
                        class="btn-success"
                    >Добавить</TheButton>
                </div>
                <hr>
                <h5 class="mb-3">Итоговый бюджет на промо-акцию: <span class="fw-bold text-primary">{{ formatNumber(totalBudget) }} руб.</span></h5>
                <div v-if="addedProducts.length > 0" class="row row-cols-xl-3 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3">
                    <DiscountProductCard
                        :products="addedProducts"
                        @remove-product="removeProduct"
                    />
                </div>
            </div>
        </div>
        <Modal
            id="modalPopUp"
            :close-func="closeModal"
            :custom-classes="['modal-lg']"
        >
            <template #title>
                Добавление ассортимента для промо-акции
            </template>
            <template #body>
                <div class="row g-3">
                    <div class="col-md-6">
                        <TheLabel for="category_id" required>Группа товара</TheLabel>
                        <select
                            v-model="state.form.categoryId"
                            @change="displayProducts"
                            id="category_id"
                            class="form-select"
                        >
                            <option disabled selected value="">-- Выберите группу товара --</option>
                            <option
                                v-for="category in state.categories"
                                :key="category.id"
                                :value="category.id"
                            >{{ category.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <TheLabel for="product_id" required>Ассортимент</TheLabel>
                        <select
                            v-model="state.form.productId"
                            id="product_id"
                            class="form-select"
                        >
                            <option disabled selected value="">-- Выберите SKU для промо-акции --</option>
                            <option
                                v-for="product in state.products"
                                :key="product.id"
                                :value="product.id"
                            >{{ product.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="sales_before" required>Продажи "До акции"</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="sales_before"
                                v-model="state.form.salesBefore"
                                type="number"
                                min="0"
                                aria-describedby="sales_before_help"
                            />
                            <span class="input-group-text">шт.</span>
                        </div>
                        <div id="sales_before_help" class="form-text">если продаж не было, укажите 0</div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="sales_plan" required>План продаж "Во время"</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="sales_plan"
                                v-model="state.form.salesPlan"
                                type="number"
                                min="0"
                            />
                            <span class="input-group-text">шт.</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="surplus_plan" required>План прироста</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="surplus_plan"
                                v-model="state.form.surplusPlan"
                                type="number"
                                disabled="disabled"
                                aria-describedby="surplus_plan_help"
                            />
                            <span class="input-group-text">%</span>
                        </div>
                        <div id="surplus_plan_help" class="form-text">рассчитывается автоматически</div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="profit_plan" required>Прибыль на 1 шт.</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="profit_plan"
                                v-model="state.form.profitPlan"
                                type="number"
                                min="0"
                                step="0.01"
                                aria-describedby="profit_plan_help"
                            />
                            <span class="input-group-text">руб.</span>
                        </div>
                        <div id="profit_plan_help" class="form-text">берётся из P&L</div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="compensation" required>Компенсация на 1 шт.</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="compensation"
                                v-model="state.form.compensation"
                                type="number"
                                min="0"
                                step="0.01"
                                aria-describedby="compensation_help"
                            />
                            <span class="input-group-text">руб.</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="budget_plan" required>Бюджет</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="budget_plan"
                                v-model="state.form.budgetPlan"
                                type="number"
                                disabled="disabled"
                                aria-describedby="budget_plan_help"
                            />
                            <span class="input-group-text">руб.</span>
                        </div>
                    </div>
                </div>
            </template>
            <template #footer>
                <TheButton
                    @click="addProduct"
                    class="btn-success w-25"
                    :disabled="!isFormValid"
                >Добавить</TheButton>
            </template>
        </Modal>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref, watch } from 'vue';
import { useHttpService } from '@/use/useHttpService.js';
import { formatNumber } from '@/helpers/formatters.js';
import Modal from '@/components/Modal.vue';
import TheButton from '@/components/core/TheButton.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import TheInput from '@/components/form/TheInput.vue';
import { MANAGER_URLS } from '@/helpers/constants.js';
import DiscountProductCard from '@/pages/Promo/DiscountProductCard.vue';

const { get } = useHttpService();

const props = defineProps({
    title: {
        type: String,
        required: true,
        default: 'Title is required',
    },
});

const emit = defineEmits([
    'addProductToPromo',
    'removeProductFromPromo',
]);

const initialFormData = () => ({
    categoryId: '',
    productId: '',
    salesBefore: 0,
    salesPlan: 0,
    surplusPlan: 0,
    profitPlan: 0,
    compensation: 0,
    budgetPlan: 0,
});

const state = reactive({
    categories: [],
    products: [],
    form: initialFormData(),
});

const addedProducts = ref([]);
const addedProductsIds = ref([]);

let modalPopUp = null;

function resetState() {
    state.products = [];
    state.form = initialFormData();
}

onMounted(async () => {
    await getCategories();
    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', resetState);
});

const getCategories = async () => {
    const { data } = await get(MANAGER_URLS.CATEGORY, {
        params: {
            'category_is_active': true,
            'product_is_active': true,
            'products': true,
        },
    });
    state.categories = data.categories;
};

const addProductModalInit = () => {
    resetState();
    modalPopUp.show();
};

const closeModal = () => {
    resetState();
    modalPopUp.hide();
    modalPopUp._element.removeEventListener('hide.bs.modal', resetState);
};

const displayProducts = () => {
    state.categories.map(category => {
        if ( +category.id === +state.form.categoryId ) {
            state.products = category.products;
        }
    });
    state.products = state.products.filter(pr => !addedProductsIds.value.includes(pr.id));
};

const addProduct = () => {
    addedProducts.value.push({
        categoryId: state.form.categoryId,
        productId: state.form.productId,
        categoryName: getCategoryName(),
        productName: getProductName(),
        salesBefore: state.form.salesBefore,
        salesPlan: state.form.salesPlan,
        surplusPlan: state.form.surplusPlan,
        budgetPlan: state.form.budgetPlan,
    });
    addedProductsIds.value.push(+state.form.productId);
    emit('addProductToPromo', state.form);
    closeModal();
};

const removeProduct = (index) => {
    addedProducts.value.splice(index, 1);
    addedProductsIds.value.splice(index, 1);
    emit('removeProductFromPromo', index);
};

const getCategoryName = () => {
  const catIdx = state.categories.findIndex(c => c.id === +state.form.categoryId);
  return state.categories[catIdx].name;
};

const getProductName = () => {
  const catIdx = state.categories.findIndex(c => c.id === +state.form.categoryId);
  const prodIdx = state.categories[catIdx].products.findIndex(p => p.id === +state.form.productId);
  return state.categories[catIdx].products[prodIdx].name;
};

const isFormValid = computed(() => {
    let valid = true;

    for (let [key, value] of Object.entries(state.form)) {
        if (key === 'salesBefore' || key === 'surplusPlan') {
            continue;
        }
        if ( !value ) {
            valid = false;
            break;
        }
    }

    return valid;
});

const totalBudget = computed(() => {
   return addedProducts.value.reduce((acc, pr) => {
       return acc + parseInt(pr.budgetPlan);
   }, 0);
});

watch(() => state.form.salesBefore,
    () => calcSurplusPlan()
);

watch(() => state.form.salesPlan,
    () => {
        calcSurplusPlan();
        calcBudgetPlan();
    }
);

watch(() => state.form.compensation,
    () => {
        calcBudgetPlan();
    }
);

function calcSurplusPlan() {
    const salesBefore = +state.form.salesBefore;
    const salesPlan = +state.form.salesPlan;
    state.form.surplusPlan = salesBefore === 0 ? 0 : ((salesPlan - salesBefore) / salesBefore * 100).toFixed();
}

function calcBudgetPlan() {
    const salesPlan = +state.form.salesPlan;
    const compensation = +state.form.compensation;
    state.form.budgetPlan = parseInt((compensation * salesPlan).toFixed(0));
}
</script>
