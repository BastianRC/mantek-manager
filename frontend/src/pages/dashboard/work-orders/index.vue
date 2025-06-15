<template>
    <WorkOrdersPage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.VIEW_ALL_WORK_ORDERS,
    layout: 'dashboard'
})

import { PERMISSIONS } from '~/modules/shared/constants/permissions';
import WorkOrdersPage from '~/modules/work-order/views/WorkOrdersPage.vue';
</script>

<style scoped></style>