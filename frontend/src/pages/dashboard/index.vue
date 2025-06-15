<template>
    <div>Dashboard</div>
</template>

<script setup lang="ts">

definePageMeta({
    redirect: '/dashboard/users',
    middleware: ['auth'],
    layout: 'dashboard'
})
</script>

<style scoped></style>