<template>
    <div>
        <div class="input-group mb-2">
            <span class="input-group-text">{{ index + 1 }}</span>
            <input
                type="text"
                class="form-control"
                v-model="props.seller.name"
                :disabled="props.seller.isActive === false"
            >
            <TheButton
                @click="updateSeller"
                class="btn-outline-primary fs-5 pt-1 pb-0"
                :disabled="props.seller.isActive === false"
            ><i :class="props.seller.isActive !== false ? 'bi-check-lg' : 'bi-dash'"></i>
            </TheButton>
            <TheButton
                @click="activateSeller"
                :class="[
                    'fs-5 pt-1 pb-0',
                    props.seller.isActive === false ? 'btn-outline-success' : 'btn-outline-danger'
                ]"
            ><i :class="props.seller.isActive !== false ? 'bi-x-lg' : 'bi-arrow-counterclockwise'"></i></TheButton>
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
