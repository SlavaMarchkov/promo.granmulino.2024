<template>
    <td>
        <button
            :class="buttonClasses"
            @click="handleClick(props.id)"
        ><i :class="iconClasses"></i>
            <slot/>
        </button>
    </td>
</template>

<script setup>
import { computed } from 'vue';
import { cva } from 'class-variance-authority';

const props = defineProps({
    id: {
        type: Number,
    },
    intent: {
        type: String,
        validator: val => ['view', 'edit', 'delete', 'create'].includes(val),
        default: 'view',
    },
});

const buttonClasses = computed(() => {
    return cva(
        'btn btn-sm',
        {
            variants: {
                intent: {
                    view: 'btn-primary',
                    edit: 'btn-warning',
                    delete: 'btn-danger',
                    create: 'btn-success',
                },
            },
        },
    )({
        intent: props.intent,
    });
});

const iconClasses = computed(() => {
    return cva(
        'bi me-2',
        {
            variants: {
                intent: {
                    view: 'bi-eye-fill',
                    edit: 'bi-pencil-square',
                },
            },
        },
    )({
        intent: props.intent,
    });
});

const emit = defineEmits([
    'initModal',
]);

const handleClick = (id) => {
    emit('initModal', id);
};
</script>
