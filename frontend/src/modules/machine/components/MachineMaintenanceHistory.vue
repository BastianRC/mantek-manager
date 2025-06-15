<template>
    <div class="space-y-4">
        <div v-if="machine.work_orders.length !== 0" v-for="(workOrder) in machine.work_orders" :key="workOrder.id"
            class="border rounded-lg p-4">
            <div class="flex items-start justify-between mb-2">
                <div>
                    <div class="flex items-center gap-2">
                        <Badge :class="getWorkOrderTypeMeta(workOrder.type).color">
                            {{ getWorkOrderTypeMeta(workOrder.type).label }}
                        </Badge>
                        <span class="text-sm text-muted-foreground">{{ workOrder.created_at }}</span>
                    </div>
                    <h4 class="font-medium mt-1">{{ workOrder.name }}</h4>
                </div>
                <div class="text-right text-sm">
                    <div class="font-medium">{{ workOrder.order_number }}</div>
                    <div class="text-muted-foreground">
                        <div class="flex items-center gap-2">
                            <span :class="`${getWorkOrderStatusMeta(workOrder.status).color} !bg-transparent`">{{
                                getWorkOrderStatusMeta(workOrder.status).label }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 text-sm text-muted-foreground">
                <Wrench class="h-4 w-4" />
                <span>Técnico: {{ workOrder.asignee }}</span>
            </div>
        </div>

        <AlertMessage v-else title="Sin historial"
            message="¡No se ha registrado ningun mantenimiento para esta máquina!" :icon="AlertCircle" />
    </div>
</template>

<script setup lang="ts">
import Badge from '~/components/ui/badge/Badge.vue';
import type { MachineDetails } from '../types/MachineDetails';
import { AlertCircle, Wrench } from 'lucide-vue-next';
import { getWorkOrderStatusMeta } from '~/modules/work-order/utils/getWorkOrderStatusMeta';
import { getWorkOrderTypeMeta } from '~/modules/work-order/utils/getWorkOrderTypeMeta';
import AlertMessage from '~/components/custom/Alert/AlertMessage.vue';


defineProps<{
    machine: MachineDetails
}>()

</script>

<style scoped></style>