<template>
    <div class="row mb-4">
        <div class="col-3">
            <TheLabel for="promo_goals">Цель промо-акции: <span class="fw-bold fs-5">{{ props.mark.goals }}</span>
            </TheLabel>
            <input
                id="promo_goals"
                v-model="props.mark.goals"
                class="form-range"
                max="5"
                min="0"
                step="0.5"
                type="range"
            />
        </div>
        <div class="col-3">
            <TheLabel for="promo_sales">Продажи: <span class="fw-bold fs-5">{{ props.mark.sales }}</span></TheLabel>
            <input
                id="promo_sales"
                v-model="props.mark.sales"
                class="form-range"
                max="5"
                min="0"
                step="0.5"
                type="range"
            />
        </div>
        <div class="col-3">
            <TheLabel for="promo_staff">Участие персонала: <span class="fw-bold fs-5">{{ props.mark.staff }}</span>
            </TheLabel>
            <input
                id="promo_staff"
                v-model="props.mark.staff"
                class="form-range"
                max="5"
                min="0"
                step="0.5"
                type="range"
            />
        </div>
        <div class="col-3 text-center">
            <TheLabel for="total_promo_mark">Средняя оценка</TheLabel>
            <TheInput
                id="total_promo_mark"
                :model-value="calcTotalPromoMark"
                class="text-center w-50 mx-auto fw-bold"
            />
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-floating">
                <textarea
                    id="promo_comments"
                    v-model="props.mark.comments"
                    class="form-control border border-dark"
                    placeholder="Укажите здесь свои выводы по промо-акции"
                    style="height: 60px;"
                ></textarea>
                <label for="promo_comments">Выводы по промо-акции</label>
            </div>
        </div>
        <div class="col-6 align-content-center">
            <TheButton
                class="btn-primary"
                @click="saveChanges"
            >Сохранить оценку и выводы
            </TheButton>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import TheButton from '@/components/core/TheButton.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import TheInput from '@/components/form/TheInput.vue';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';

const { getAverageOfArray } = useArrayHandlers();

const props = defineProps({
    mark: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits([
    'updatePromoMark',
]);

const generateMarkArray = () => {
    const obj = {
        sales: props.mark.sales,
        goals: props.mark.goals,
        staff: props.mark.staff,
    };
    return Array.from(Object.entries(obj), ([key, value]) => value);
};

const calcTotalPromoMark = computed(() => {
    const arr = generateMarkArray();
    return getAverageOfArray(arr);
});

const saveChanges = () => {
    emit('updatePromoMark', props.mark);
};
</script>
