<template>
    <ChronologiesPage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.VIEW_ALL_CHRONOLOGIES,
    layout: 'dashboard'
})

import ChronologiesPage from '~/modules/chronology/views/ChronologiesPage.vue';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';
</script>

<style scoped></style>