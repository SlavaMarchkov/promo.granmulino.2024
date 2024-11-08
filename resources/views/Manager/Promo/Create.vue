<template>
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header bg-primary text-white">Укажите общие данные промо-акции</div>
                <div class="card-body mt-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <TheLabel for="promo_id" required>Вид промо-акции</TheLabel>
                            <select
                                v-model="state.promo.promoId"
                                @change="displayPromoType"
                                id="promo_id"
                                class="form-select"
                            >
                                <option disabled selected value="">-- Выберите вид промо-акции --</option>
                                <option
                                    v-for="promo in PROMO_TYPES"
                                    :key="promo.id"
                                    :value="promo.id"
                                >{{ promo.title }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <pre>
                        {{ state.promo }}
                    </pre>
                    <Button
                        @click="savePromo"
                        type="button"
                        class="btn-primary w-25"
                    >
                        Сохранить
                    </Button>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <TheDiscount
                v-show="currentPromoType === 'discount'"
                :categories="state.categories"
                @add-product-to-promo="addProductHandler"
            ></TheDiscount>
            <div v-show="currentPromoType === 'sales_people_boost'" class="card">
                <div class="card-header bg-secondary text-white">Мотивация торгового персонала</div>
                <div class="card-body">
                    Участники из команды ТП
                </div>
            </div>
            <div v-show="currentPromoType === 'gift_for_purchase'" class="card">
                <div class="card-header bg-danger-light text-white">Подарок за покупку</div>
                <div class="card-body">
                    Ассортимент для подарков за покупку
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useHttpService } from '@/use/useHttpService.js';
import TheLabel from '@/components/form/TheLabel.vue';
import { MANAGER_URLS, PROMO_TYPES } from '@/helpers/constants.js';
import TheDiscount from '@/pages/TheDiscount.vue';
import Button from '@/components/core/Button.vue';

const { get, post } = useHttpService();

const initialFormData = () => ({
    name: '',
    promoId: '',
    country: '',
    state: '',
    products: [],
});

const state = reactive({
    categories: [],
    regions: [],
    promo: initialFormData(),
});

let currentPromoType = ref('');

onMounted(async () => {
    await getCategories();
});

const getCategories = async () => {
    const { data } = await get(MANAGER_URLS.CATEGORY, {
        params: {
            'is_active': true,
        },
    });
    state.categories = data.categories;
};

const displayPromoType = () => {
    const promoId = +state.promo.promoId;
    currentPromoType.value = PROMO_TYPES.find(pt => pt.id === promoId).value;
};

const addProductHandler = (product) => {
    state.promo.products.push(product);
};

const savePromo = async () => {
    const response = await post(MANAGER_URLS.PROMO, state.promo);
    console.log(response);
    if ( response && response.status === 'success' ) {
        state.promo = initialFormData();
    }
};
</script>
