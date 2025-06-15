<template>
    <div>
        <LoginPage />
    </div>
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['guest']
})

import LoginPage from '~/modules/auth/views/LoginPage.vue';
</script>

<style scoped></style>