<template>
    <RolesPage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.VIEW_ALL_ROLES,
    layout: 'dashboard'
})

import RolesPage from '~/modules/role/views/RolesPage.vue';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';
</script>

<style scoped></style>