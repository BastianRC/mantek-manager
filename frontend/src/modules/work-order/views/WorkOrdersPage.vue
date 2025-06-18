<template>
    <LoadingScreen :visible="isFetching" />

    <HeaderComponent title="Gestión de Órdenes de Trabajo" subtitle="Gestiona y supervisa todas las órdenes de trabajo">
        <template v-slot:buttons>
            <Button v-if="hasPermission(PERMISSIONS.CREATE_WORK_ORDER)" @click="navigateTo('work-orders/new')">
                <PlusIcon class="mr-0 size-4" />
                <span class="hidden md:block">Nueva OT</span>
            </Button>

            <Button @click="refetch">
                <RefreshCcw class="mr-0 size-4" />
                <span class="hidden md:block">Refrescar</span>
            </Button>
        </template>
    </HeaderComponent>

    <div class="container mx-auto p-6">
        <StatsComponent class="xl:grid-cols-5" :stats="stats" />
        <WorkOrderDataList v-if="workOrders" :work-orders="workOrders" @filtered="filteredWorkOrder = $event" />
    </div>
</template>

<script setup lang="ts">
import type { StatItem } from '~/components/custom/Stats/StatItem'
import { useGetWorkOrdersList } from '../composables/useGetWorkOrdersList'
import type { WorkOrder } from '../types/WorkOrder'
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue'
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue'
import Button from '~/components/ui/button/Button.vue'
import { AlertTriangle, CircleCheckBig, Clock, PlusIcon, RefreshCcw, Users, Wrench } from 'lucide-vue-next'
import StatsComponent from '~/components/custom/Stats/StatsComponent.vue'
import WorkOrderDataList from '../components/DataList/WorkOrderDataList.vue'
import { hasPermission } from '~/modules/shared/helpers/permissions'
import { PERMISSIONS } from '~/modules/shared/constants/permissions'

const { data: workOrders, isFetching, suspense, refetch } = useGetWorkOrdersList()

const filteredWorkOrder: Ref<WorkOrder[]> = ref([])

const stats = computed<StatItem[]>(() => {
    const workOrdersList = workOrders.value ?? []

    const totalWorkOrders = workOrdersList.length
    const pendingWorkOrders = workOrdersList.filter((m) => m.status === 'pending').length
    const inProgressWorkOrders = workOrdersList.filter((m) => m.status === 'in_progress').length
    const completedWorkOrders = workOrdersList.filter((m) => m.status === 'completed').length
    const criticalPriorityWorkOrders = workOrdersList.filter((m) => m.priority === 'critical').length

    return [
        { title: 'Total OTs', icon: Wrench, color: '', value: totalWorkOrders },
        { title: 'Pendientes', icon: Clock, color: 'text-yellow-600', value: pendingWorkOrders },
        { title: 'En Progreso', icon: Users, color: 'text-blue-600', value: inProgressWorkOrders },
        { title: 'Completadas', icon: CircleCheckBig, color: 'text-green-600', value: completedWorkOrders },
        { title: 'Prioridad Critica', icon: AlertTriangle, color: 'text-red-600', value: criticalPriorityWorkOrders },
    ]
})

onServerPrefetch(async () => {
    await suspense()
})
</script>

<style scoped></style>