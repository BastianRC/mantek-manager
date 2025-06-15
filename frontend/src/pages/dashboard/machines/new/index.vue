<template>
    <MachineCreatePage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.CREATE_MACHINE,
    layout: 'dashboard'
})

import { PERMISSIONS } from '~/modules/shared/constants/permissions';
import MachineCreatePage from '~/modules/machine/views/new/MachineCreatePage.vue';
</script>

<style scoped></style>