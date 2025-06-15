<template>
    <div class="flex-1 flex flex-col items-center justify-center">
        <h2 class="font-extrabold text-8xl">403</h2>
        <span class="font-light uppercase text-3xl">Acceso no permitido</span>
        <img class="mt-5 w-[90%] max-w-lg" :src="forbidden" alt="Forbidden">
    </div>
</template>

<script setup lang="ts">

definePageMeta({
    middleware: ['auth'],
    layout: 'dashboard'
})

import forbidden from '@/assets/images/forbidden.svg'
import BackgroundCard from '~/components/custom/Card/BackgroundCard.vue';

</script>

<style scoped></style>