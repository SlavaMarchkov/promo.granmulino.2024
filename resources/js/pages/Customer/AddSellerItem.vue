<template>
    <TheLabel for="sellerName" required>Новый торговый представитель или супервайзер</TheLabel>
    <div class="input-group mb-2">
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
    <TheCheckbox
        id="isSupervisor"
        v-model="state.seller.isSupervisor"
    >Отметить, если ТП - это супервайзер</TheCheckbox>
</template>

<script setup>
import TheLabel from '@/components/form/TheLabel.vue';
import TheInput from '@/components/form/TheInput.vue';
import TheButton from '@/components/core/TheButton.vue';
import { reactive } from 'vue';
import TheCheckbox from '@/components/form/TheCheckbox.vue';

const props = defineProps({
    customerId: {
        type: Number,
        required: true,
    },
});

const initialFormData = () => ({
    customerId: props.customerId,
    supervisorId: '',
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
