<template>
    <Alert />
    <div v-if="sellers.length > 0" class="row">
        <SellerItem
            v-for="(seller, index) in sellers"
            :key="seller.id"
            :seller="seller"
            :index="index"
            @activate-seller="activateSeller"
            @update-seller="updateSeller"
        />
    </div>
    <div v-else class="row">
        <p>Команда торговых представителей ещё не наполнена!<br>Наполните команду, вводя поочерёдно ФИО торговых представителей в поле ниже.</p>
    </div>
    <hr>
    <AddSellerItem
        :customer-id="props.customerId"
        @save-seller="saveSeller"
    />
</template>

<script setup>
import Alert from '@/components/Alert.vue';
import SellerItem from '@/pages/Customer/SellerItem.vue';
import AddSellerItem from '@/pages/Customer/AddSellerItem.vue';
import { useHttpService } from '@/use/useHttpService.js';
import { useAlertStore } from '@/stores/alerts.js';
import { MANAGER_URLS } from '@/helpers/constants.js';

const { post, update } = useHttpService();
const alertStore = useAlertStore();

const props = defineProps({
    customerId: {
        type: Number,
        required: true,
    },
    sellers: {
        type: Array,
        required: true,
        default: [],
    },
});

const emit = defineEmits([
    'updateSellers',
]);

const saveSeller = async (item) => {
    let url = `${ MANAGER_URLS.CUSTOMER }/${ props.customerId }/`;
    url += item.isSupervisor ? [MANAGER_URLS.CUSTOMER_SUPERVISOR] : [MANAGER_URLS.CUSTOMER_SELLER];
    const { status, data } = await post(url, item);
    if ( status === 'success' ) {
        alertStore.clear();
        emit('updateSellers', data);
    }
};

const updateSeller = async (item) => {
    const { status, data } = await update(`${ MANAGER_URLS.CUSTOMER_SELLER }/${ item.id }`, item);
    if ( status === 'success' ) {
        alertStore.clear();
        emit('updateSellers', data);
    }
};

const activateSeller = async (item) => {
    const { status, data } = await update(`${ MANAGER_URLS.CUSTOMER_SELLER }/${ item.id }`, {
        ...item,
        isActive: !item.isActive
    });
    if ( status === 'success' ) {
        emit('updateSellers', data);
    }
};
</script>
