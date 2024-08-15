<template>
    <div class="col-md-2 mb-2">
        <div class="input-group">
            <div class="input-group-text">
                <input
                    id="local"
                    class="form-check-input mt-0"
                    name="type"
                    type="radio"
                    value="local"
                    @change="filter"
                >
            </div>
            <label
                class="form-control text-start"
                for="local"
            >
                Локальная
            </label>
        </div>
    </div>
    <div class="col-md-2 mb-2">
        <div class="input-group">
            <div class="input-group-text">
                <input
                    id="regional"
                    class="form-check-input mt-0"
                    name="type"
                    type="radio"
                    value="regional"
                    @change="filter"
                >
            </div>
            <label
                class="form-control text-start"
                for="regional"
            >
                Региональная
            </label>
        </div>
    </div>
    <div class="col-md-2 mb-2">
        <div class="input-group">
            <div class="input-group-text">
                <input
                    id="federal"
                    class="form-check-input mt-0"
                    name="type"
                    type="radio"
                    value="federal"
                    @change="filter"
                >
            </div>
            <label
                class="form-control text-start"
                for="federal"
            >
                Федеральная
            </label>
        </div>
    </div>
    <div class="col-md-2 mb-2">
        <div class="input-group">
            <div class="input-group-text">
                <input
                    id="all"
                    checked
                    class="form-check-input mt-0"
                    name="type"
                    type="radio"
                    value="all"
                    @change="filter"
                >
            </div>
            <label
                class="form-control text-start"
                for="all"
            >
                Все типы ТС
            </label>
        </div>
    </div>
</template>

<script setup>
const emit = defineEmits([
    'filter',
]);

const filter = (evt) => {
    emit('filter', evt.target.value);
};
</script>
