<template>
    <UserCreatePage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.CREATE_USER,
    layout: 'dashboard'
})

import { PERMISSIONS } from '~/modules/shared/constants/permissions';
import UserCreatePage from '~/modules/user/views/new/UserCreatePage.vue';
</script>

<style scoped></style>