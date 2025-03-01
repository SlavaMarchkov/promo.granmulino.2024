<template>
    <RouterLink
        :to="{ name: 'Category.Index' }"
        class="fw-bold"
        role="button"
    ><i class="bi bi-arrow-bar-left me-2"></i>Обратно на Группы товаров
    </RouterLink>
    <hr>
    <div v-if="isItemFound" class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ item.name }}</h5>
                </div>
                <div class="card-body pt-3">
                    <table class="table table-bordered mb-0 align-middle text-wrap"
                           style="width: 100%;">
                        <tbody>
                        <tr>
                            <th style="width: 30%;">ID</th>
                            <td>{{ item.id }}</td>
                        </tr>
                        <tr>
                            <th>Название</th>
                            <td>{{ item.name }}</td>
                        </tr>
                        <tr>
                            <th>Количество SKU в группе</th>
                            <td>{{ item.productsCount }}</td>
                        </tr>
                        <tr>
                            <th>В продаже?</th>
                            <td>
                                <TheBadge :is-active="item.isActive"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <TheButton
                        @click="navigateToPreviousItem"
                        class="btn-outline-secondary"
                        :disabled="item.prev === null"
                    >Пред.</TheButton>
                    <TheButton
                        @click="navigateToNextItem"
                        class="btn-outline-secondary mx-2"
                        :disabled="item.next === null"
                    >След.</TheButton>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">Продукция группы товаров</div>
                <div class="card-body pt-3">
                    <table
                        v-if="item.products.length > 0"
                        class="table table-bordered text-center mb-0 align-middle text-nowrap"
                    >
                        <thead class="table-light">
                        <tr>
                            <th style="width: 10%;">#</th>
                            <th class="text-start" style="width: 45%;">Формат</th>
                            <th style="width: 15%;">Вес, г</th>
                            <th v-if="role === ROLES['PRICE_ADMIN']">Себестоимость, руб.</th>
                            <th style="width: 15%;">В продаже?</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(product, index) in item.products" :key="product.id">
                            <td>{{ index + 1 }}</td>
                            <td class="text-start">
                                <RouterLink
                                    :to="{ name: 'Product.View', params: { id: product.id } }"
                                >
                                    {{ product.name }}
                                </RouterLink>
                            </td>
                            <td>{{ formatNumber(product.weight) }}</td>
                            <td v-if="role === ROLES['PRICE_ADMIN']">{{ product.price }}</td>
                            <td>
                                <TheBadge :is-active="product.isActive" />
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p v-else class="lead mb-0">Группа товаров не имеет продукции.</p>
                </div>
            </div>
        </div>
    </div>
    <Alert v-else class="mt-3"/>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHttpService } from '@/use/useHttpService.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useAuthStore } from '@/stores/auth.js';
import Alert from '@/components/Alert.vue';
import { ADMIN_URLS, ROLES } from '@/helpers/constants.js';
import TheBadge from '@/components/core/TheBadge.vue';
import TheButton from '@/components/core/TheButton.vue';
import { formatNumber } from '@/helpers/formatters.js';

const route = useRoute();
const router = useRouter();
const spinnerStore = useSpinnerStore();
const authStore = useAuthStore();
const role = authStore.getUser.role;

const { get } = useHttpService();
const id = +route.params.id;

const item = ref({});

onMounted(async () => {
    await fetchDetails(id);
});

const fetchDetails = async (id) => {
    const response = await get(`${ ADMIN_URLS.CATEGORY }/${ id }`);
    if ( response.status === 'success' ) item.value = response.data;
};

watch(
    () => route.params.id,
    () => {
        fetchDetails(route.params.id);
    },
);

const isItemFound = computed(() => {
    return Object.keys(item.value).length !== 0;
});

const navigateToPreviousItem = () => {
    router.push({ name: 'Category.View', params: { id: item.value.prev } });
};

const navigateToNextItem = () => {
    router.push({ name: 'Category.View', params: { id: item.value.next } });
};
</script>
