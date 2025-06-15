<template>
    <div class="space-y-4">
        <div v-if="location.work_orders.length !== 0" class="space-y-4">
            <div v-for="(workOrder) in location.work_orders" :key="workOrder.id"
                class="flex items-center justify-between p-4 border rounded-lg">
                <div class="flex items-center gap-3">
                    <Wrench class="h-8 w-8 text-muted-foreground" />
                    <div>
                        <p class="font-medium">{{ workOrder.name }}</p>
                        <p class="text-sm text-muted-foreground">
                            {{ workOrder.order_number }} • Asignado a: {{ workOrder.asignee }}
                        </p>
                        <p class="text-xs text-muted-foreground">
                            Creado: {{ workOrder.created_at }} • Vence: {{ workOrder.due_at }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <Badge :class="`${getWorkOrderStatusMeta(workOrder.status).color} border`">
                        {{ getWorkOrderStatusMeta(workOrder.status).label }}
                    </Badge>
                </div>
            </div>
        </div>

        <AlertMessage v-else title="Sin resultados" message="¡No se han encotrado órdenes de trabajo!" :icon="AlertCircle" variant="default" />
    </div>
</template>

<script setup lang="ts">
import { AlertCircle, Cpu, Wrench } from 'lucide-vue-next';
import type { LocationDetails } from '../types/LocationDetails';
import Badge from '~/components/ui/badge/Badge.vue';
import AlertMessage from '~/components/custom/Alert/AlertMessage.vue';
import { getWorkOrderStatusMeta } from '~/modules/work-order/utils/getWorkOrderStatusMeta';

const props = defineProps<{
    location: LocationDetails,
}>()

</script>

<style scoped></style>