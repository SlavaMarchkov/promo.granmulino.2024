<template>
    <TheLabel for="sellerName" required>Новый торговый представитель</TheLabel>
    <div class="input-group mb-3">
        <TheInput
            id="sellerName"
            v-model="state.seller.name"
            placeholder="ФИО торгового представителя"
        />
        <TheButton
            @click="saveSeller"
            class="btn-success"
        >Добавить</TheButton>
    </div>
</template>

<script setup>
import TheLabel from '@/components/form/TheLabel.vue';
import TheInput from '@/components/form/TheInput.vue';
import TheButton from '@/components/core/TheButton.vue';
import { reactive } from 'vue';

const props = defineProps({
    customerId: {
        type: Number,
        required: true,
    },
});

const initialFormData = () => ({
    customerId: props.customerId,
    name: '',
    isActive: true,
});

const state = reactive({
    seller: initialFormData(),
});

const emit = defineEmits([
    'saveSeller',
]);

const saveSeller = () => {
    emit('saveSeller', state.seller);
    state.seller = initialFormData();
};
</script>
