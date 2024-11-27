<template>
    <li class="list-group-item m-0 px-2">
        <div class="row g-2">
            <div class="col-md-5 col-sm-12">
                <div class="input-group">
                    <input
                        :value="props.seller.shortName"
                        class="form-control"
                        readonly
                        type="text"
                    >
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <input

                    class="form-control text-end"
                    type="text"
                >
            </div>
            <div class="col-md-2 col-sm-6">
                <input
                    v-model="DEFAULT_SURPLUS_PERCENT"
                    class="form-control text-end"
                    readonly
                    type="text"
                >
            </div>
            <div class="col-md-2 col-sm-6">
                <input

                    class="form-control text-end"
                    readonly
                    type="text"
                >
            </div>
            <div class="col-md-1 col-sm-6 text-center">
                <TheButton
                    class="btn-outline-danger"
                    @click="removeSeller(seller.id, index)"
                ><i class="bi-x-lg"></i></TheButton>
            </div>
        </div>
    </li>
</template>

<script setup>
import { DEFAULT_SURPLUS_PERCENT } from '@/helpers/constants.js';
import TheButton from '@/components/core/TheButton.vue';

const props = defineProps({
    seller: {
        type: Object,
        required: true,
    },
});
</script>
