<template>
    <li class="list-group-item m-0 px-2">
        <div class="row g-2">
            <div class="col-md-1">{{ index + 1 }}</div>
            <div class="col-md-3">some2</div>
            <div class="col-md-2">some3</div>
            <div class="col-md-2">some4</div>
            <div class="col-md-2">some5</div>
            <div class="col-md-2">some6</div>
        </div>
    </li>
</template>

<script setup>
const props = defineProps({
    index: {
        type: Number,
        default: 1,
    },
    product: {
        type: Object,
        required: true,
    },
});
</script>

<style scoped>

</style>
