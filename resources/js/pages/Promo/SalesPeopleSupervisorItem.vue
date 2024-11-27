<template>
    <li class="list-group-item m-0 px-2">
        <div class="row g-2">
            <div class="col-md-5 col-sm-12">
                <div class="input-group">
                    <span class="input-group-text">{{ index + 1 }}</span>
                    <input
                        :value="props.supervisor.shortName"
                        class="form-control fw-bold"
                        readonly
                        type="text"
                    >
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <input
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
            <div class="col-md-2 col-sm-6">
                <input
                    class="form-control text-end"
                    readonly
                    type="text"
                >
            </div>
            <div class="col-md-1 col-sm-6 text-center"></div>
        </div>
    </li>
    <template
        v-for="seller in props.sellers"
        :key="seller.id"
    >
        <SalesPeopleSellerItem
            v-if="seller.supervisorId === props.supervisor.id"
            :seller="seller"
        />
    </template>
</template>

<script setup>
import SalesPeopleSellerItem from '@/pages/Promo/SalesPeopleSellerItem.vue';

const props = defineProps({
    supervisor: {
        type: Object,
        required: true,
    },
    index: {
        type: Number,
        default: 1,
    },
    sellers: {
        type: Array,
        required: true,
        default: () => [],
    },
});
</script>
