<template>
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>{{ props.brand }}</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://pmgu.ru/">PixelMind Guru</a>
        </div>
    </footer>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
</template>

<script setup>
import { onMounted } from 'vue';

const props = {
    brand,
};

onMounted(() => {
    toggleBackToTop();
    onScroll(document, toggleBackToTop);
});

const toggleBackToTop = () => {
    const backToTopBtn = document.querySelector('.back-to-top');

    if ( backToTopBtn ) {
        if ( window.scrollY > 100 ) {
            backToTopBtn.classList.add('active');
        } else {
            backToTopBtn.classList.remove('active');
        }
    }
};

const onScroll = (el, listener) => {
    el.addEventListener('scroll', listener);
};
</script>
