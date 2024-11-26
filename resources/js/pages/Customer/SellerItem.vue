<template>
    <div>
        <div class="input-group mb-2">
            <span class="input-group-text">{{ index + 1 }}</span>
            <input
                type="text"
                class="form-control"
                v-model="props.seller.name"
                :disabled="!props.seller.isActive"
                :style="!props.seller.isActive ? 'cursor: not-allowed' : ''"
            >
            <TheButton
                @click="updateSellerName"
                class="btn-outline-primary fs-5 pt-1 pb-0"
                :disabled="!props.seller.isActive"
                :style="!props.seller.isActive ? 'cursor: not-allowed' : ''"
                title="Сохранить изменения"
            ><i :class="props.seller.isActive !== false ? 'bi-check-lg' : 'bi-dash'"></i>
            </TheButton>
            <TheButton
                v-if="props.seller.supervisorId === null"
                @click="upgradeSeller"
                class="btn-outline-secondary fs-5 pt-1 pb-0"
                :disabled="!props.seller.isActive"
                :style="!props.seller.isActive ? 'cursor: not-allowed' : ''"
                title="Сделать супервайзером"
            ><i class="bi-arrow-up"></i>
            </TheButton>
            <TheButton
                v-else
                @click="detachSeller"
                class="btn-outline-secondary fs-5 pt-1 pb-0"
                :disabled="!props.seller.isActive"
                :style="!props.seller.isActive ? 'cursor: not-allowed' : ''"
                title="Переместить в ТП"
            ><i class="bi-arrow-down"></i>
            </TheButton>
            <TheButton
                @click="toggleSellerStatus"
                :class="[
                    'fs-5 pt-1 pb-0',
                    props.seller.isActive === false ? 'btn-outline-success' : 'btn-outline-danger'
                ]"
                :title="props.seller.isActive !== false ? 'Деактивировать' : 'Активировать'"
            ><i :class="props.seller.isActive !== false ? 'bi-x-lg' : 'bi-arrow-counterclockwise'"></i>
            </TheButton>
            <TheButton
                @click="destroySeller"
                class="btn-outline-danger fs-5 pt-1 pb-0"
                :disabled="props.seller.isActive || props.seller.supervisorId !== null"
                :style="props.seller.isActive || props.seller.supervisorId !== null ? 'cursor: not-allowed' : ''"
                title="Удалить"
            ><i class="bi-trash"></i>
            </TheButton>
        </div>
    </div>
</template>

<script setup>
import TheButton from '@/components/core/TheButton.vue';

const props = defineProps({
    seller: {
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
]);

const toggleSellerStatus = () => {
    props.seller.isActive = !props.seller.isActive;
    emit('updateSeller', props.seller);
};

const updateSellerName = () => {
    emit('updateSeller', props.seller);
};

const upgradeSeller = () => {
    props.seller.isSupervisor = true;
    emit('updateSeller', props.seller);
};

const detachSeller = () => {
    props.seller.supervisorId = null;
    emit('updateSeller', props.seller);
};

const destroySeller = () => {
    emit('destroySeller', props.seller);
};
</script>
