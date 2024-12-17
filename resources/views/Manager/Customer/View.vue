<template>
    <div v-if="spinnerStore.isLoading" class="row">
        <div class="col-12">
            <h4 class="my-4"><TheSpinner /></h4>
        </div>
    </div>
    <template v-else>
        <div v-if="isItemFound" class="row profile">
            <div class="col-xl-4">
                <TheCard
                    :body-classes="['profile-card pt-2 d-flex flex-column']"
                    :header-classes="['bg-light']"
                    class="mb-4"
                >
                    <template #header>
                        <h2 class="mb-0">{{ item.name }}</h2>
                    </template>
                    <template #body>
                        <TwoColumnRow cols="3" title="<h3>Регион</h3>"><h3>{{ item.region.name }}</h3></TwoColumnRow>
                        <TwoColumnRow title="<h3>Город</h3>"><h3>{{ item.city.name }}</h3></TwoColumnRow>
                        <TwoColumnRow title="<h3>Работает</h3>">
                            <TheBadge :is-active="item.isActive"/>
                        </TwoColumnRow>
                    </template>
                </TheCard>
                <TheCard :header-classes="['bg-light']">
                    <template #header>
                        <h4 class="mb-0">Торговые сети</h4>
                    </template>
                    <template #body>
                        <div v-if="item.retailers.length > 0" class="list-group">
                            <button
                                v-for="(retailer, index) in item.retailers"
                                :key="retailer.id"
                                class="list-group-item list-group-item-action"
                                type="button"
                            >
                                <RouterLink
                                    :to="{ name: 'Manager.Retailer.View', params: { id: retailer.id }}"
                                    class="d-flex justify-content-between text-black"
                                >
                                    <span>{{ index + 1 }}. <span class="fw-bold">{{  retailer.name }}</span></span>
                                    <span class="text-primary">Подробнее</span>
                                </RouterLink>
                            </button>
                        </div>
                        <p v-else class="mb-0">Дистрибутор не имеет торговых сетей.</p>
                    </template>
                </TheCard>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" aria-selected="true" role="tab">Профиль</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="false" tabindex="-1" role="tab">Прайс-лист</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings" aria-selected="false" tabindex="-1" role="tab">Настройки</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#the-sellers" aria-selected="false" tabindex="-1" role="tab">Команда ТП</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview" role="tabpanel">
                                <h5 class="card-title">В разработке</h5>
                            </div>
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit" role="tabpanel">
                                <h5 class="card-title">В разработке</h5>
                            </div>
                            <div class="tab-pane fade pt-3" id="profile-settings" role="tabpanel">
                                <h5 class="card-title">В разработке</h5>
                            </div>
                            <div class="tab-pane fade pt-1" id="the-sellers" role="tabpanel">
                                <TheSellers
                                    :customer-id="customerId"
                                    :supervisors="supervisors"
                                    :sellers="sellers"
                                    @update-sellers="updateSellers"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Alert v-else class="mt-3"/>
    </template>
    <hr>
    <RouterLink
        :to="{ name: 'Manager.Customer.Index' }"
        class="btn btn-secondary my-2"
        role="button"
    >Обратно на Мои Контрагенты
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
import TheSellers from '@/pages/Customer/TheSellers.vue';
import TheBadge from '@/components/core/TheBadge.vue';
import TheSpinner from '@/components/core/TheSpinner.vue';
import TheCard from '@/components/core/TheCard.vue';
import TwoColumnRow from '@/components/core/TwoColumnRow.vue';

const route = useRoute();
const router = useRouter();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();

const { get } = useHttpService();
const customerId = +route.params.id;

const item = ref({});
const supervisors = ref([]);
const sellers = ref([]);

onMounted(async () => {
    await fetchDetails(customerId);
});

const isItemFound = computed(() => {
    return Object.keys(item.value).length !== 0;
});

const fetchDetails = async (customerId) => {
    await get(`${ MANAGER_URLS.CUSTOMER }/${ customerId }`, {
        params: {
            city: true,
            region: true,
            retailers: true,
            customer_supervisors: false,
            customer_sellers: false,
        }
    }).then(({ status, data }) => {
        if ( status === 'success' ) item.value = data;
    }).then(() => fetchSellers(customerId));
};

const fetchSellers = async (customerId) => {
    const { status, data } = await get(`${MANAGER_URLS.CUSTOMER}/${customerId}${MANAGER_URLS.SELLER}`);
    if ( status === 'success' ) {
        supervisors.value = data.sellers.filter(s => s.isSupervisor === true);

        const tempArr1 = data.sellers.filter(s => !supervisors.value.includes(s));

        tempArr1.forEach(seller => {
            if (seller.isSupervisor !== true && seller.supervisorId === null) {
                sellers.value.push(seller);
            } else {
                const idx = supervisors.value.findIndex(s => s.id === seller.supervisorId);
                supervisors.value[idx].sellers.push(seller);
                const tempArr = arrayHandlers.sortArrayByStringColumn(supervisors.value[idx].sellers, 'name');
                supervisors.value[idx].sellers = arrayHandlers.sortArrayByBoolean(tempArr, 'isActive');
            }
        });

        const tempArr2 = arrayHandlers.sortArrayByStringColumn(sellers.value, 'name');
        sellers.value = arrayHandlers.sortArrayByBoolean(tempArr2, 'isActive');

        const tempArr3 = arrayHandlers.sortArrayByStringColumn(supervisors.value, 'name');
        supervisors.value = arrayHandlers.sortArrayByBoolean(tempArr3, 'isActive');
    }
};

watch(
    () => route.params.id,
    () => fetchDetails(route.params.id),
);

const updateSellers = (updatedItem) => {
    const sellerIdx = sellers.value.findIndex(s => s.id === updatedItem.id);
    const supervisorIdx = supervisors.value.findIndex(s => s.id === updatedItem.id);

    // обновляем имя или статус ТП, привязанных к супервайзеру (вложенные ТП)
    if (sellerIdx === -1 && supervisorIdx === -1 && updatedItem.isSupervisor === false && updatedItem.supervisorId !== null) {
        const supervisorIdx = supervisors.value.findIndex(s => s.id === updatedItem.supervisorId);
        const idx = supervisors.value[supervisorIdx].sellers.findIndex(s => s.id === updatedItem.id);
        supervisors.value[supervisorIdx].sellers[idx] = updatedItem;
        const tempArr = arrayHandlers.sortArrayByStringColumn(supervisors.value[supervisorIdx].sellers, 'name');
        supervisors.value[supervisorIdx].sellers = arrayHandlers.sortArrayByBoolean(tempArr, 'isActive');
    }

    // добавляем нового супервайзера либо переносим ТП из списка супервайзеров по кнопке вниз
    if (sellerIdx === -1 && supervisorIdx === -1 && updatedItem.isSupervisor === true && updatedItem.supervisorId === null) {
        if (updatedItem.sellers.length === 0) {
            supervisors.value.push(updatedItem);
        } else {
            supervisors.value.forEach(({ sellers }) => {
                const idx = sellers.findIndex(s => s.id === updatedItem.id);
                sellers.splice(idx, 1);
            });
        }
    }

    // добавляем нового ТП или переносим из прикрепленных к супервайзеру ТП по кнопке вниз
    if (sellerIdx === -1 && supervisorIdx === -1 && updatedItem.isSupervisor === false && updatedItem.supervisorId === null) {
        sellers.value.push(updatedItem);
        supervisors.value.forEach(({ sellers }) => {
            const idx = sellers.findIndex(s => s.id === updatedItem.id);
            if (idx !== -1) {
                sellers.splice(idx, 1);
                arrayHandlers.sortArrayByStringColumn(sellers, 'name');
            }
        });
    }

    // переносим из супервайзеров в ТП по кнопке вниз
    if (sellerIdx === -1 && supervisorIdx !== -1 && updatedItem.isSupervisor === false && updatedItem.supervisorId === null) {
        sellers.value.push(updatedItem);
        supervisors.value.splice(supervisorIdx, 1);
    }

    // переносим из ТП в супервайзеров по кнопке вверх
    if (sellerIdx !== -1 && supervisorIdx === -1 && updatedItem.isSupervisor === true) {
        supervisors.value.push(updatedItem);
        sellers.value.splice(sellerIdx, 1);
    }

    // перетаскиваем одного ТП в список супервайзеров
    if (sellerIdx !== -1 && supervisorIdx === -1 && updatedItem.isSupervisor === false && updatedItem.supervisorId !== null) {
        sellers.value.splice(sellerIdx, 1);
        const supervisorIdx = supervisors.value.findIndex(s => s.id === updatedItem.supervisorId);
        supervisors.value[supervisorIdx].sellers.push(updatedItem);
        arrayHandlers.sortArrayByStringColumn(supervisors.value[supervisorIdx].sellers, 'name');
    }

    // меняем имя ТП в списке ТП либо обновляем статус ТП либо удаляем
    if (sellerIdx !== -1 && supervisorIdx === -1 && updatedItem.isSupervisor === false && updatedItem.supervisorId === null) {
        if (updatedItem.deletedAt !== null) {
            sellers.value.splice(sellerIdx, 1);
        } else {
            sellers.value[sellerIdx] = updatedItem;
        }
    }

    // меняем имя супервайзера в списке супервайзеров либо обновляем его статус либо удаляем
    if (supervisorIdx !== -1 && updatedItem.isSupervisor === true) {
        if (updatedItem.deletedAt !== null) {
            supervisors.value.splice(supervisorIdx, 1);
        } else {
            const sellers = supervisors.value[supervisorIdx].sellers;
            supervisors.value[supervisorIdx] = updatedItem;
            supervisors.value[supervisorIdx].sellers = sellers;
        }
    }

    const tempArr1 = arrayHandlers.sortArrayByStringColumn(sellers.value, 'name');
    sellers.value = arrayHandlers.sortArrayByBoolean(tempArr1, 'isActive');

    const tempArr2 = arrayHandlers.sortArrayByStringColumn(supervisors.value, 'name');
    supervisors.value = arrayHandlers.sortArrayByBoolean(tempArr2, 'isActive');
};
</script>
