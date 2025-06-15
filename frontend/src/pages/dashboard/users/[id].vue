<template>
    <UserProfilePage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.VIEW_USER,
    layout: 'dashboard'
})

import { PERMISSIONS } from '~/modules/shared/constants/permissions';
import UserProfilePage from '~/modules/user/views/UserProfilePage.vue';
</script>

<style scoped></style>