<template>
    <RoleCreatePage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.CREATE_ROLE,
    layout: 'dashboard'
})

import { PERMISSIONS } from '~/modules/shared/constants/permissions';
import RoleCreatePage from '~/modules/role/views/new/RoleCreatePage.vue';
</script>

<style scoped></style>