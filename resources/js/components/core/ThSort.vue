<template>
    <th
        scope="col"
        :style="{ width: props.width + 'px' }"
        :class="props.orderColumn === props.id ? 'table-active' : ''"
    >
        <div @click="handleClick(props.id)" style="cursor: pointer;">
            <slot/>
            <i
                :class="[
                    'bi',
                    'ms-1',
                    props.sortType === 'numeric' ?
                    {
                        'bi-sort-numeric-down-alt':
                            props.orderDirection === 'desc' &&
                            props.orderColumn === props.id,
                        'bi-sort-numeric-up':
                            props.orderDirection !== '' &&
                            props.orderDirection !== 'desc' &&
                            props.orderColumn === props.id,
                        'bi-three-dots-vertical opacity-25':
                            props.orderColumn !== props.id,
                    } : props.sortType === 'alpha' ?
                    {
                        'bi-sort-alpha-down-alt':
                            props.orderDirection === 'desc' &&
                            props.orderColumn === props.id,
                        'bi-sort-alpha-up':
                            props.orderDirection !== '' &&
                            props.orderDirection !== 'desc' &&
                            props.orderColumn === props.id,
                        'bi-three-dots-vertical opacity-25':
                            props.orderColumn !== props.id,
                    } :
                    {
                        'bi-sort-up':
                            props.orderDirection === 'desc' &&
                            props.orderColumn === props.id,
                        'bi-sort-down-alt':
                            props.orderDirection !== '' &&
                            props.orderDirection !== 'desc' &&
                            props.orderColumn === props.id,
                        'bi-three-dots-vertical opacity-25':
                            props.orderColumn !== props.id,
                    },
                ]"
            ></i>
        </div>
    </th>
</template>

<script setup>
const props = defineProps({
    id: {
        type: String,
        default: 'id',
    },
    orderColumn: {
        type: String,
        default: 'id',
    },
    orderDirection: {
        type: String,
        default: 'desc',
    },
    width: Number,
    sortType: {
        type: String,
        default: '',
    },
});

const emit = defineEmits([
    'sortByColumn',
]);

const handleClick = (column) => {
    emit('sortByColumn', column);
};
</script>
