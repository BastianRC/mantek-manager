<template>
    <LocationsPage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.VIEW_ALL_LOCATIONS,
    layout: 'dashboard'
})

import LocationsPage from '~/modules/location/views/LocationsPage.vue'
import { PERMISSIONS } from '~/modules/shared/constants/permissions';
</script>

<style scoped></style>