<template>
    <div class="input-group mb-2">
        <span class="input-group-text">{{ index + 1 }}</span>
        <input
            type="text"
            class="form-control"
            v-model="props.item.name"
            :disabled="props.item.isActive === false"
        >
        <TheButton
            @click="updateSeller"
            class="btn-outline-primary fs-5 pt-1 pb-0"
            :disabled="props.item.isActive === false"
        ><i :class="props.item.isActive !== false ? 'bi-check-lg' : 'bi-dash'"></i>
        </TheButton>
        <TheButton
            @click="activateSeller"
            :class="[
                'fs-5 pt-1 pb-0',
                props.item.isActive === false ? 'btn-outline-success' : 'btn-outline-danger'
            ]"
        ><i :class="props.item.isActive !== false ? 'bi-x-lg' : 'bi-arrow-counterclockwise'"></i></TheButton>
    </div>
    <div
        v-if="props.item.sellers && props.item.sellers.length > 0"
        class="ps-5"
    >
        <SellerItem
            v-for="(item, index) in props.item.sellers"
            :key="item.id"
            :index="index"
            :item="item"
            @activate-seller="activateSeller"
            @update-seller="updateSeller"
        />
    </div>
</template>

<script setup>
import TheButton from '@/components/core/TheButton.vue';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
    index: {
        type: Number,
        default: 1,
    },
});

const emit = defineEmits([
    'activateSeller',
    'updateSeller',
]);

const activateSeller = () => {
    emit('activateSeller', props.seller);
};

const updateSeller = () => {
    emit('updateSeller', props.seller);
};
</script>
