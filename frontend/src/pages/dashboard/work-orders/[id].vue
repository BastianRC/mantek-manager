<template>
    <WorkOrderProfilePage />
</template>

<script setup lang="ts">


definePageMeta({
    middleware: ['auth', 'permission'],
    permission: PERMISSIONS.VIEW_WORK_ORDER,
    layout: 'dashboard'
})

import WorkOrderProfilePage from '~/modules/work-order/views/WorkOrderProfilePage.vue';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';

</script>

<style scoped></style>