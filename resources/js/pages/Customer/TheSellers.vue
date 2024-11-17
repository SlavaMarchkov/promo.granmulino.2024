<template>
    <Alert />
    <div
        v-if="sellers.length > 0"
        class="row"
    >
        <div
            v-for="(item, index) in sellers"
            :key="item.id"
            class="input-group mb-2"
        >
            <span class="input-group-text">{{ index + 1 }}</span>
            <input
                type="text"
                class="form-control"
                v-model="item.name"
                :disabled="item.isActive === false"
            >
            <button
                @click="updateSeller(item)"
                class="btn btn-outline-primary fs-5 py-0"
                type="button"
                :disabled="item.isActive === false"
            ><i :class="item.isActive !== false ? 'bi-check-lg' : 'bi-dash'"></i></button>
            <button
                @click="activateSeller(item)"
                :class="[
                    'btn fs-5 py-0',
                    item.isActive === false ? 'btn-outline-success' : 'btn-outline-danger'
                ]"
                type="button"
            ><i :class="item.isActive !== false ? 'bi-x-lg' : 'bi-arrow-counterclockwise'"></i></button>
        </div>
    </div>
    <div v-else class="row">
        <p>Команда торговых представителей ещё не наполнена!<br>Наполните команду, вводя поочерёдно ФИО торговых представителей в поле ниже.</p>
    </div>
    <hr>
    <TheLabel for="sellerName" required>Новый торговый представитель</TheLabel>
    <div class="input-group mb-3">
        <input
            v-model="state.seller.name"
            id="sellerName"
            type="text"
            class="form-control"
            placeholder="ФИО торгового представителя">
        <button
            @click="saveSeller"
            class="btn btn-success"
            type="button"
        >Добавить</button>
    </div>
</template>

<script setup>
import { reactive } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useHttpService } from '@/use/useHttpService.js';
import Alert from '@/components/Alert.vue';
import TheLabel from '@/components/form/TheLabel.vue';
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

const initialFormData = () => ({
    customerId: props.customerId,
    name: '',
    isActive: true,
});

const state = reactive({
    seller: initialFormData(),
});

const saveSeller = async () => {
    const { status, data } = await post(MANAGER_URLS.CUSTOMER_SELLER, state.seller);
    if ( status === 'success' ) {
        alertStore.clear();
        emit('updateSellers', data);
        state.seller = initialFormData();
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
