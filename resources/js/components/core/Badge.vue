<template>
    <span
        :class="[
			'badge',
			props.isActive ? 'bg-success' : 'bg-secondary',
		]"
    >
        <i
            :class="[
                'bi me-2',
                props.isActive ? 'bi-check-circle' : 'bi-info-circle',
            ]"
        ></i>
        {{ props.isActive ? 'Да&nbsp;' : 'Нет' }}
    </span>
</template>

<script setup>
const props = defineProps({
    isActive: {
        type: Number,
        default: 1,
    },
});
</script>
