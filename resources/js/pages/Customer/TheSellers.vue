<template>
    <h4 class="mb-3">Супервайзеры с привязанными ТП</h4>
    <div v-if="props.supervisors.length > 0" class="row">
        <SupervisorItem
            v-for="(supervisor, index) in props.supervisors"
            :key="supervisor.id"
            :supervisor="supervisor"
            :index="index"
            @drop="onDrop($event, supervisor.id)"
            @dragover.prevent
            @dragenter.prevent
            @update-supervisor="updateSeller"
            @destroy-supervisor="deleteSeller"
            @update-seller="updateSeller"
            @destroy-seller="deleteSeller"
        />
    </div>
    <div v-else class="row">
        <div class="col-12">
            <div class="bd-callout bd-callout-warning mb-0">
                <p class="mb-0"><span class="fw-bold text-danger">Не добавлено ни одного супервайзера!</span><br>Введите поочерёдно ФИО супервайзеров, отметив при этом галочку.</p>
            </div>
        </div>
    </div>
    <hr>
    <h4 class="mb-3">Торговые представители без привязки к супервайзерам</h4>
    <div v-if="props.sellers.length > 0" class="row">
        <SellerItem
            v-for="(seller, index) in props.sellers"
            :key="seller.id"
            :seller="seller"
            :index="index"
            @dragstart="onDragStart($event, seller)"
            :draggable="!!seller.isActive"
            @update-seller="updateSeller"
            @destroy-seller="deleteSeller"
        />
    </div>
    <div v-else class="row">
        <div class="col-12">
            <div class="bd-callout bd-callout-warning mb-0">
                <p class="mb-0">Наполните команду:<br>Шаг 1. Введите поочерёдно ФИО торговых представителей.<br>Шаг 2. Привяжите их к супервайзерам перетаскиванием мышкой.</p>
            </div>
        </div>
    </div>
    <hr>
    <Alert/>
    <AddSellerItem
        :customer-id="props.customerId"
        @save-seller="saveSeller"
    />
</template>

<script setup>
import Alert from '@/components/Alert.vue';
import SupervisorItem from '@/pages/Customer/SupervisorItem.vue';
import SellerItem from '@/pages/Customer/SellerItem.vue';
import AddSellerItem from '@/pages/Customer/AddSellerItem.vue';
import { useHttpService } from '@/use/useHttpService.js';
import { useAlertStore } from '@/stores/alerts.js';
import { MANAGER_URLS } from '@/helpers/constants.js';

const { post, update, destroy } = useHttpService();
const alertStore = useAlertStore();

const props = defineProps({
    customerId: {
        type: Number,
        required: true,
    },
    supervisors: {
        type: Array,
        required: true,
        default: [],
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
    const { status, data } = await post(`${MANAGER_URLS.CUSTOMER}/${props.customerId}${MANAGER_URLS.SELLER}`, item);
    if ( status === 'success' ) {
        alertStore.clear();
        emit('updateSellers', data);
    }
};

const updateSeller = async (item) => {
    const {
        status,
        data,
    } = await update(`${MANAGER_URLS.CUSTOMER}/${props.customerId}${MANAGER_URLS.SELLER}/${item.id}`, item);
    if ( status === 'success' ) {
        alertStore.clear();
        emit('updateSellers', data);
    }
};

const deleteSeller = async (item) => {
    if ( confirm('Точно удалить сотрудника? Уверены?') ) {
        const {
            status,
            data,
        } = await destroy(`${MANAGER_URLS.CUSTOMER}/${props.customerId}${MANAGER_URLS.SELLER}/${item.id}`, item);
        if ( status === 'success' ) {
            console.log(data);
            emit('updateSellers', data);
        }
    }
};

function onDrop(evt, supervisorId) {
    const seller = JSON.parse(evt.dataTransfer.getData('item'));
    seller.supervisorId = supervisorId;
    updateSeller(seller);
}

function onDragStart(evt, item) {
    evt.dataTransfer.dropEffect = 'move';
    evt.dataTransfer.effectAllowed = 'move';
    evt.dataTransfer.setData('item', JSON.stringify(item));
}
</script>
