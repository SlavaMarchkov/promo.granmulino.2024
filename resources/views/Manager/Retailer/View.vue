<template>
    <div v-if="spinnerStore.isLoading" class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="my-4">Загрузка...</h4>
                </div>
            </div>
        </div>
    </div>
    <template v-else>
        <div v-if="isItemFound" class="row profile">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-3 d-flex flex-column">
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <h1>{{ item.name }}</h1>
                            <h4><span :class="['badge', 'rounded', item.typeBgColor]">{{ item.label }}</span></h4>
                        </div>
                        <h3>Дистрибутор:
                            <RouterLink
                                :to="{ name: 'Manager.Customer.View', params: { id: item.customerId } }"
                            >{{ item.customer }}
                            </RouterLink>
                        </h3>
                        <h3>Город: {{ item.city }}</h3>
                        <h3>Работает: <TheBadge :is-active="item.isActive" /></h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">

                    </div>
                </div>
            </div>
        </div>
        <Alert v-else class="mt-3"/>
    </template>
    <hr>
    <RouterLink
        :to="{ name: 'Manager.Retailer.Index' }"
        class="btn btn-secondary my-2"
        role="button"
    >Обратно на Мои торговые сети
    </RouterLink>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { MANAGER_URLS } from '@/helpers/constants.js';
import Alert from '@/components/Alert.vue';
import TheBadge from '@/components/core/TheBadge.vue';

const route = useRoute();
const router = useRouter();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();

const { get } = useHttpService();
const retailerId = +route.params.id;

const item = ref({});

onMounted(async () => {
    await fetchDetails(retailerId);
});

const fetchDetails = async (retailerId) => {
    const { status, data } = await get(`${ MANAGER_URLS.RETAILER }/${ retailerId }`);
    if ( status === 'success' ) item.value = data;
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
</script>
