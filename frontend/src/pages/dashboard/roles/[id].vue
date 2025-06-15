<template>
    <RoleProfilePage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.VIEW_ROLE,
    layout: 'dashboard'
})

import RoleProfilePage from '~/modules/role/views/RoleProfilePage.vue';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';
</script>

<style scoped></style>