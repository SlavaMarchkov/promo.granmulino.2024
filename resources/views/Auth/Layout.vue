<template>
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4">
                                <div class="logo d-flex align-items-center w-auto">
                                    <img src="/assets/img/logo.png" alt="">
                                    <span class="d-block">{{ props.brand }}</span>
                                </div>
                            </div>
                            <RouterView></RouterView>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>
<script setup>
const props = {
    brand,
};
</script>
