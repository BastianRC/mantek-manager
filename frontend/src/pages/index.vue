<template>
    <div></div>
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['guest']
})

navigateTo('/login')
</script>

<style scoped></style>