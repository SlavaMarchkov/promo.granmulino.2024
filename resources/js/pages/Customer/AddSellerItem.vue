<template>
    <TheLabel for="sellerName" required>Новый торговый представитель или супервайзер</TheLabel>
    <div class="row g-2">
        <div class="col-md-5">
            <TheInput
                id="sellerName"
                v-model="state.seller.name"
                placeholder="ФИО торгового представителя"
            />
        </div>
        <div class="col-md-5">
            <TheCheckbox
                id="isSupervisor"
                v-model="state.seller.isSupervisor"
            >Отметить, если ТП - это супервайзер</TheCheckbox>
        </div>
        <div class="col-md-2">
            <TheButton
                @click="saveSeller"
                class="btn-success w-100"
                :loading="spinnerStore.isLoading"
                :disabled="spinnerStore.isLoading"
            >Добавить</TheButton>
        </div>
    </div>
</template>

<script setup>
import TheLabel from '@/components/form/TheLabel.vue';
import TheInput from '@/components/form/TheInput.vue';
import TheButton from '@/components/core/TheButton.vue';
import { reactive } from 'vue';
import TheCheckbox from '@/components/form/TheCheckbox.vue';
import { useSpinnerStore } from '@/stores/spinners.js';

const spinnerStore = useSpinnerStore();

const props = defineProps({
    customerId: {
        type: Number,
        required: true,
    },
});

const initialFormData = () => ({
    customerId: props.customerId,
    customerSupervisorId: '',
    name: '',
    isActive: true,
    isSupervisor: false,
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
