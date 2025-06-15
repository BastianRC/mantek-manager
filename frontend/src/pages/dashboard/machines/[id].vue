<template>
    <MachineProfilePage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.VIEW_MACHINE,
    layout: 'dashboard'
})

import MachineProfilePage from '~/modules/machine/views/MachineProfilePage.vue';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';

</script>

<style scoped></style>