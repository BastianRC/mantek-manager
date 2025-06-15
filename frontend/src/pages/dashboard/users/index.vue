<template>
    <UsersPage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.VIEW_ALL_USERS,
    layout: 'dashboard'
})

import { PERMISSIONS } from '~/modules/shared/constants/permissions';
import UsersPage from '~/modules/user/views/UsersPage.vue';
</script>

<style scoped></style>