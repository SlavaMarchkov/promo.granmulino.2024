<template>
    <div>
        <div class="input-group mb-2">
            <span class="input-group-text">{{ index + 1 }}</span>
            <input
                type="text"
                class="form-control fw-bold"
                v-model="props.supervisor.name"
                :disabled="props.supervisor.isActive === false"
            >
            <TheButton
                @click="updateSupervisor"
                class="btn-outline-primary fs-5 pt-1 pb-0"
                :disabled="props.supervisor.isActive === false"
            ><i :class="props.supervisor.isActive !== false ? 'bi-check-lg' : 'bi-dash'"></i>
            </TheButton>
            <TheButton
                @click="activateSupervisor"
                :class="[
                    'fs-5 pt-1 pb-0',
                    props.supervisor.isActive === false ? 'btn-outline-success' : 'btn-outline-danger'
                ]"
            ><i :class="props.supervisor.isActive !== false ? 'bi-x-lg' : 'bi-arrow-counterclockwise'"></i></TheButton>
        </div>
        <div
            v-if="props.supervisor.sellersCount > 0"
            class="ps-5"
        >
            <SellerItem
                v-for="(seller, index) in props.supervisor.sellers"
                :key="seller.id"
                :seller="seller"
                :index="index"
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
    'activateSupervisor',
    'updateSupervisor',
]);

const activateSupervisor = () => {
    emit('activateSupervisor', props.supervisor);
};

const updateSupervisor = () => {
    emit('updateSupervisor', props.supervisor);
};
</script>
