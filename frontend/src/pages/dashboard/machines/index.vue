<template>
    <MachinesPage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.VIEW_ALL_MACHINES,
    layout: 'dashboard'
})

import MachinesPage from '~/modules/machine/views/MachinesPage.vue';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';
</script>

<style scoped></style>