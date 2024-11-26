<template>
    <div>
        <div class="input-group mb-2">
            <span class="input-group-text">{{ index + 1 }}</span>
            <input
                type="text"
                class="form-control fw-bold"
                v-model="props.supervisor.name"
                :disabled="!props.supervisor.isActive"
                :style="!props.supervisor.isActive ? 'cursor: not-allowed' : ''"
            >
            <TheButton
                @click="updateSupervisorName"
                class="btn-outline-primary fs-5 pt-1 pb-0"
                :disabled="!props.supervisor.isActive"
                :style="!props.supervisor.isActive ? 'cursor: not-allowed' : ''"
                title="Сохранить изменения"
            ><i :class="props.supervisor.isActive !== false ? 'bi-check-lg' : 'bi-dash'"></i>
            </TheButton>
            <TheButton
                @click="downgradeSupervisor"
                class="btn-outline-secondary fs-5 pt-1 pb-0"
                :disabled="props.supervisor.sellers.length > 0"
                :style="props.supervisor.sellers.length > 0 ? 'cursor: not-allowed' : ''"
                title="Разжаловать в ТП"
            ><i class="bi-arrow-down"></i>
            </TheButton>
            <TheButton
                @click="toggleSupervisorStatus"
                :class="[
                    'fs-5 pt-1 pb-0',
                    props.supervisor.isActive === false ? 'btn-outline-success' : 'btn-outline-danger'
                ]"
                :disabled="props.supervisor.sellers.length > 0"
                :style="props.supervisor.sellers.length > 0 ? 'cursor: not-allowed' : ''"
                :title="props.supervisor.isActive !== false ? 'Деактивировать' : 'Активировать'"
            ><i :class="props.supervisor.isActive !== false ? 'bi-x-lg' : 'bi-arrow-counterclockwise'"></i>
            </TheButton>
            <TheButton
                @click="destroySupervisor"
                class="btn-outline-danger fs-5 pt-1 pb-0"
                :disabled="props.supervisor.sellers.length > 0 || props.supervisor.isActive"
                :style="(props.supervisor.sellers.length > 0 || props.supervisor.isActive) ? 'cursor: not-allowed' : ''"
                title="Удалить"
            ><i class="bi-trash"></i>
            </TheButton>
        </div>
        <div
            v-if="props.supervisor.sellers.length > 0"
            class="ps-5"
        >
            <SellerItem
                v-for="(seller, index) in props.supervisor.sellers"
                :key="seller.id"
                :seller="seller"
                :index="index"
                @update-seller="updateSeller(seller)"
                @destroy-seller="destroySeller(seller)"
            />
        </div>
    </div>
</template>

<script setup>
import SellerItem from '@/pages/Customer/SellerItem.vue';
import TheButton from '@/components/core/TheButton.vue';

const props = defineProps({
    supervisor: {
        type: Object,
        required: true,
    },
    index: {
        type: Number,
        default: 1,
    },
});

const emit = defineEmits([
    'updateSeller',
    'destroySeller',
    'updateSupervisor',
    'destroySupervisor',
]);

const updateSeller = (seller) => {
    if (seller.isSupervisor === true) {
        seller.supervisorId = null;
    }
    emit('updateSeller', seller);
};

const destroySeller = (seller) => {
    emit('destroySeller', seller);
};

const toggleSupervisorStatus = () => {
    props.supervisor.isActive = !props.supervisor.isActive;
    emit('updateSupervisor', props.supervisor);
};

const updateSupervisorName = () => {
    emit('updateSupervisor', props.supervisor);
};

const downgradeSupervisor = () => {
    props.supervisor.isSupervisor = false;
    emit('updateSupervisor', props.supervisor);
};

const destroySupervisor = () => {
    emit('destroySupervisor', props.supervisor);
};
</script>
