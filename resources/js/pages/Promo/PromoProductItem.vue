<template>
    <li class="list-group-item m-0 px-3">
        <div class="row align-items-center g-1">
            <div class="col-md-1 text-center">{{ index + 1 }}</div>
            <div class="col-md-4 fw-bold">{{ product.categoryName }} / {{ product.productName }}</div>
            <div class="col-md-2 border">some3</div>
            <div class="col-md-2">some4</div>
            <div class="col-md-2">some5</div>
            <div class="col-md-1">
                <TdButton
                    :id="product.id"
                    intent="edit"
                    class="w-100"
                    @runButtonHandler="modals.editModalPopUp = true"
                >Edit</TdButton>
            </div>
        </div>
    </li>

    <TheModal
        v-if="modals.editModalPopUp"
        v-model="modals.editModalPopUp"
        id="editModalPopUp"
        :custom-classes="['modal-xl']"
    >
        <template #title>
            <h4>Редактирование акционного продукта</h4>
            <p class="mb-1">Группа товара: <span class="fw-bold text-primary">{{ product.categoryName }}</span></p>
            <p class="mb-1">Продукт: <span class="fw-bold text-primary">{{ product.productName }}</span></p>
        </template>
        <template #body>
            <pre>{{ props.product }}</pre>
        </template>
        <template #footer>
            <TheButton
                class="btn-warning w-25"
                type="button"
                @click="saveProductItem"
            >Сохранить изменения</TheButton>
        </template>
    </TheModal>
</template>

<script setup>
import TheButton from '@/components/core/TheButton.vue';
import TheModal from '@/components/TheModal.vue';
import TdButton from '@/components/table/TdButton.vue';
import { reactive } from 'vue';

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

const modals = reactive({
    editModalPopUp: false,
});

const saveProductItem = async () => {
    console.log('saving...');
    //editModalPopUp.hide();
    // get(`${MANAGER_URLS.PROMO}/${promoId}`);
    /*const response = await post(ADMIN_URLS.CATEGORY, state.category);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        state.category = initialFormData();
        editModalPopUp.hide();
        arrayHandlers.resetSearchKeys(searchBy);
        arrayHandlers.resetSortKeys('id', false);
        await getCategories();
    }*/
};
</script>

<style scoped>

</style>
