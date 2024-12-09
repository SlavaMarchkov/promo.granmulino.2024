<template>
    <div class="col">
        <div class="card mb-0">
            <h5 class="card-header">Some Promo</h5>
            <div class="card-body mt-3">
                <ul class="mb-0 list-unstyled">
                    <li><strong>Регион</strong>:</li>
                    <li><strong>Город</strong>:</li>
                </ul>
                <pre>{{ props.promo }}</pre>
            </div>
            <div class="card-footer">
                <RouterLink
                    :to="{ name: 'Manager.Promo.View', params: { id: promo.id }}"
                    class="btn btn-outline-primary"
                >Подробнее
                </RouterLink>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    promo: {
        type: Object,
    },
});
</script>
