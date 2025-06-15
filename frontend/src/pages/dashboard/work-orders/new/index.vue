<template>
    <WorkOrderCreatePage />
</template>

<script setup lang="ts">
definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.CREATE_WORK_ORDER,
    layout: 'dashboard'
})

import { PERMISSIONS } from '~/modules/shared/constants/permissions';
import WorkOrderCreatePage from '~/modules/work-order/views/new/WorkOrderCreatePage.vue';
</script>

<style scoped></style>