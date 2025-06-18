<template>
    <div>Dashboard</div>
</template>

<script setup lang="ts">

definePageMeta({
    middleware: ['auth', 'redirect'],
    layout: 'dashboard'
})
</script>

<style scoped></style>