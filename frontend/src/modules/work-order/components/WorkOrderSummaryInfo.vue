<template>
    <div class="space-y-4">
        <div class="text-center">
            <h3 class="font-semibold text-lg">{{ workOrder.order_number }}</h3>
            <p class="text-muted-foreground">{{ workOrder.title }}</p>
        </div>
        <div class="flex justify-center gap-2">
            <Badge :class="getWorkOrderStatusMeta(workOrder.status).color">
                {{ getWorkOrderStatusMeta(workOrder.status).label }}
            </Badge>
            <Badge :class="getWorkOrderPriorityMeta(workOrder.priority).color">
                {{ getWorkOrderPriorityMeta(workOrder.priority).label }}
            </Badge>
        </div>
    </div>
</template>

<script setup lang="ts">
import Badge from '~/components/ui/badge/Badge.vue';
import type { WorkOrderDetails } from '../types/WorkOrderDetails';
import { getWorkOrderPriorityMeta } from '../utils/getWorkOrderPriorityMeta';
import { getWorkOrderStatusMeta } from '../utils/getWorkOrderStatusMeta';

defineProps<{
    workOrder: WorkOrderDetails
}>()
</script>

<style scoped></style>