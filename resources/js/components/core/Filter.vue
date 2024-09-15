<template>
    <form autocomplete="off">
        <fieldset>
            <legend>Фильтр</legend>
            <div class="row">
                <slot/>
            </div>
            <button
                class="btn btn-secondary my-2"
                type="button"
                @click="$emit('resetFilter')"
            >
                Сбросить фильтр
            </button>
        </fieldset>
    </form>
</template>

<script setup>
defineEmits([
    'resetFilter',
]);
</script>
