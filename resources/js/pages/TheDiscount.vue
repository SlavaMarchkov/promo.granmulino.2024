<template>
    <div>
        <div class="card">
            <div class="card-header bg-success text-white">Скидка в цене</div>
            <div class="card-body mt-3">
                <p>Ассортимент для промо-акции</p>
                <button
                    @click="addProductModalInit"
                    class="btn btn-success"
                    type="button"
                >
                    Добавить
                </button>
                <hr>
                <table v-if="addedProducts.length > 0" class="table table-striped align-middle">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Группа товара</th>
                        <th scope="col">Формат</th>
                        <th scope="col">До</th>
                        <th scope="col">Во время</th>
                        <th scope="col">Прирост</th>
                        <th scope="col">Бюджет</th>
                        <th scope="col">Del</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="(pr, index) in addedProducts"
                        :key="index"
                    >
                        <th scope="row">{{ index + 1 }}</th>
                        <td>{{ pr.categoryName }}</td>
                        <td>{{ pr.productName }}</td>
                        <td>{{ pr.salesBefore }}</td>
                        <td>{{ pr.salesPlan }}</td>
                        <td>{{ pr.surplusPlan }}</td>
                        <td>{{ pr.budgetPlan }}</td>
                        <td>
                            <button
                                class="btn btn-danger"
                                @click="removeProduct(index)"
                            >X</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
                            @change="displayProduct"
                            id="category_id"
                            class="form-select"
                        >
                            <option disabled selected value="">-- Выберите группу товара --</option>
                            <option
                                v-for="category in props.categories"
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
                        <TheLabel for="profit_unit" required>Прибыль на 1 шт.</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="profit_unit"
                                v-model="state.form.profitUnit"
                                type="number"
                                min="0"
                                step="0.01"
                                aria-describedby="profit_unit_help"
                            />
                            <span class="input-group-text">руб.</span>
                        </div>
                        <div id="profit_unit_help" class="form-text">берётся из P&L</div>
                    </div>
                    <div class="col-md-4">
                        <TheLabel for="compensation_unit" required>Компенсация на 1 шт.</TheLabel>
                        <div class="input-group">
                            <TheInput
                                id="compensation_unit"
                                v-model="state.form.compensationUnit"
                                type="number"
                                min="0"
                                step="0.01"
                                aria-describedby="compensation_unit_help"
                            />
                            <span class="input-group-text">руб.</span>
                        </div>
<!--                        <div id="compensation_unit_help" class="form-text">компенсация ТД АЛТАН на 1 шт. продукции</div>-->
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
<!--                        <div id="budget_plan_help" class="form-text">Компенсация на 1 шт. * План продаж "Во время"</div>-->
                    </div>
                </div>
            </template>
            <template #footer>
                <Button
                    @click="addProduct"
                    type="button"
                    class="btn-success w-25"
                    :disabled="!isFormValid"
                >
                    Добавить
                </Button>
            </template>
        </Modal>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref, watch } from 'vue';
import Modal from '@/components/Modal.vue';
import Button from '@/components/core/Button.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import TheInput from '@/components/form/TheInput.vue';

const props = defineProps({
    categories: {
        type: Array,
        default: [],
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
    profitUnit: 0,
    compensationUnit: 0,
    budgetPlan: 0,
});

const state = reactive({
    products: [],
    form: initialFormData(),
});

const addedProducts = ref([]);

let modalPopUp = null;

function resetState() {
    state.form = initialFormData();
}

onMounted(() => {
    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', resetState);
});

const addProductModalInit = () => {
    modalPopUp.show();
};

const closeModal = () => {
    modalPopUp.hide();
    modalPopUp._element.removeEventListener('hide.bs.modal', resetState);
};

const displayProduct = () => {
    props.categories.map(category => {
        if ( +category.id === +state.form.categoryId ) {
            state.products = category.products;
        }
    });
};

const addProduct = () => {
    addedProducts.value.push({
        categoryName: getCategoryName(),
        productName: getProductName(),
        salesBefore: state.form.salesBefore,
        salesPlan: state.form.salesPlan,
        surplusPlan: state.form.surplusPlan,
        budgetPlan: state.form.budgetPlan,
    });
    emit('addProductToPromo', state.form);
    closeModal();
};

const removeProduct = (index) => {
    addedProducts.value.splice(index, 1);
    emit('removeProductFromPromo', index);
};

const getCategoryName = () => {
  const catIdx = props.categories.findIndex(c => c.id === +state.form.categoryId);
  return props.categories[catIdx].name;
};

const getProductName = () => {
  const catIdx = props.categories.findIndex(c => c.id === +state.form.categoryId);
  const prodIdx = props.categories[catIdx].products.findIndex(p => p.id === +state.form.productId);
  return props.categories[catIdx].products[prodIdx].name;
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

watch(() => state.form.salesBefore,
    () => calcSurplusPlan()
);

watch(() => state.form.salesPlan,
    () => {
        calcSurplusPlan();
        calcBudgetPlan();
    }
);

watch(() => state.form.compensationUnit,
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
    const compensationUnit = +state.form.compensationUnit;
    state.form.budgetPlan = compensationUnit * salesPlan;
}
</script>
