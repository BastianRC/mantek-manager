<template>
    <LocationCreatePage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.CREATE_LOCATION,
    layout: 'dashboard'
})

import LocationCreatePage from '~/modules/location/views/new/LocationCreatePage.vue';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';
</script>

<style scoped></style>