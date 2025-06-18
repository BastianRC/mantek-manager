<template>
    <DataList v-if="workOrders" :items="workOrders" :search-keys="['title', 'asignee.name', 'location.name']"
        :filters="filters" :items-per-page-options="[6, 12, 24]" title="Lista de Órdenes de Trabajo"
        @filtered="$emit('filtered', $event)" :grid-class="'block space-y-4'">
        <template #item="{ item }">
            <Card v-for="(workOrder) in item as WorkOrder[]" :key="workOrder.id"
                class="transition-colors hover:bg-muted/50">
                <CardContent>
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="mb-2 flex flex-wrap items-center gap-3">
                                <div class="flex items-center gap-2">
                                    <div v-if="workOrder.status === 'in_progress' && workOrder.is_started"
                                        class="!bg-transparent" :class="`${getWorkOrderStateMeta(workOrder.is_started, workOrder.is_paused).color}`">
                                        <div class="relative flex items-center justify-start">
                                            <component class="absolute opacity-75 size-5"
                                                :class="{ 'animate-ping': !workOrder.is_paused, 'hidden': workOrder.is_paused }"
                                                :is="getWorkOrderStateMeta(workOrder.is_started, workOrder.is_paused).icon" />
                                            <component class="relative size-5"
                                                :is="getWorkOrderStateMeta(workOrder.is_started, workOrder.is_paused).icon" />
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-semibold">{{ workOrder.title }}</h3>
                                </div>
                                <Badge :class="`${getWorkOrderStatusMeta(workOrder.status).color} border`">
                                    <component :is="getWorkOrderStatusMeta(workOrder.status).icon"></component>
                                    {{ getWorkOrderStatusMeta(workOrder.status).label }}
                                </Badge>
                                <Badge :class="`${getWorkOrderPriorityMeta(workOrder.priority).color} border`">
                                    <component :is="getWorkOrderPriorityMeta(workOrder.priority).icon"></component>
                                    {{ getWorkOrderPriorityMeta(workOrder.priority).label }}
                                </Badge>
                            </div>

                            <p class="mb-3 text-muted-foreground">{{ workOrder.description }}</p>
                            <div class="grid gap-4 text-sm md:grid-cols-5">
                                <div>
                                    <span class="font-medium text-muted-foreground">ID:</span>
                                    <p>{{ workOrder.order_number }}</p>
                                </div>
                                <div>
                                    <span class="font-medium text-muted-foreground">Ubicación:</span>
                                    <p>{{ workOrder.location.name }}</p>
                                </div>
                                <div>
                                    <span class="font-medium text-muted-foreground">Categoría:</span>
                                    <p>{{ workOrder.machine?.category.name ?? '---' }}</p>
                                </div>
                                <div>
                                    <span class="font-medium text-muted-foreground">Tipo:</span>
                                    <p>{{ getWorkOrderTypeMeta(workOrder.type).label ?? '---' }}</p>
                                </div>
                                <div>
                                    <span class="font-medium text-muted-foreground">Horas estimadas:</span>
                                    <p>{{ workOrder.estimated_hours }}</p>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center"
                                :class="workOrder.assignee ? 'justify-between' : 'justify-end'">
                                <div v-if="workOrder.assignee" class="flex items-center gap-2">
                                    <Avatar class="size-12">
                                        <AvatarImage :src="workOrder.assignee?.avatar_url ?? ''" />
                                        <AvatarFallback>{{ getInitials(workOrder.assignee?.name) }}</AvatarFallback>
                                    </Avatar>
                                    <div>
                                        <p class="text-sm font-medium">{{ workOrder.assignee.name }}</p>
                                        <p class="text-xs text-muted-foreground">Técnico asignado</p>
                                    </div>
                                </div>

                                <div class="text-right text-sm">
                                    <p class="text-muted-foreground">Creado: {{ workOrder.created_at }}</p>
                                    <p class="text-muted-foreground">Vence: {{ workOrder.due_at }}</p>
                                </div>
                            </div>
                        </div>

                        <DropdownComponent :items="getDropdownItems(workOrder)" />
                    </div>
                </CardContent>
            </Card>
        </template>
    </DataList>
</template>

<script setup lang="ts">
import Card from '~/components/ui/card/Card.vue';
import CardContent from '~/components/ui/card/CardContent.vue';
import Badge from '~/components/ui/badge/Badge.vue';
import { filters } from './filters';
import DataList from '~/components/custom/DataList/DataList.vue';
import { useDeleteWorkOrder } from '../../composables/useDeleteWorkOrder';
import type { WorkOrder } from '../../types/WorkOrder';
import { getWorkOrderStatusMeta } from '../../utils/getWorkOrderStatusMeta';
import { getWorkOrderPriorityMeta } from '../../utils/getWorkOrderPriorityMeta';
import { getInitials } from '~/lib/utils';
import Avatar from '~/components/ui/avatar/Avatar.vue';
import AvatarImage from '~/components/ui/avatar/AvatarImage.vue';
import AvatarFallback from '~/components/ui/avatar/AvatarFallback.vue';
import { getWorkOrderTypeMeta } from '../../utils/getWorkOrderTypeMeta';
import type { DropdownButtons } from '~/components/custom/Dropdown/DropdownComponent.vue';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';
import DropdownComponent from '~/components/custom/Dropdown/DropdownComponent.vue';
import { getWorkOrderStateMeta } from '../../utils/getWorkOrderStateMeta';

const { setEditMode } = useEditMode()

const { mutate: destroy } = useDeleteWorkOrder()

const props = defineProps<{
    workOrders: WorkOrder[]
}>()

function getDropdownItems(workOrder: WorkOrder): DropdownButtons[] {
    return [
        {
            text: 'Ver perfil',
            click: () => navigateTo(`work-orders/${workOrder.id}`),
            canView: PERMISSIONS.VIEW_WORK_ORDER
        },
        {
            text: 'Editar OT',
            click: () => {
                setEditMode(true)
                navigateTo(`work-orders/${workOrder.id}`)
            },
            canView: PERMISSIONS.UPDATE_WORK_ORDER
        },
        {
            text: 'Eliminar',
            click: () => destroy(workOrder.id),
            class: 'text-destructive',
            separatorBefore: true,
            canView: PERMISSIONS.DELETE_WORK_ORDER
        }
    ]
}

</script>

<style scoped></style>