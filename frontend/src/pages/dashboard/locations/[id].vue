<template>
    <LocationProfilePage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.VIEW_LOCATION,
    layout: 'dashboard'
})

import LocationProfilePage from '~/modules/location/views/LocationProfilePage.vue';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';

</script>

<style scoped></style>