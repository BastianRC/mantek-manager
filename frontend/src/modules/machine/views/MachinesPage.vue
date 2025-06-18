<template>
    <LoadingScreen :visible="isFetching" />

    <HeaderComponent title="Gestión de Máquinas" subtitle="Monitorea y gestiona el estado de todas las maquinas">
        <template v-slot:buttons>
            <Button v-if="hasPermission(PERMISSIONS.CREATE_MACHINE)" @click="navigateTo('machines/new')">
                <PlusIcon class="mr-0 size-4" />
                <span class="hidden md:block">Nueva Máquina</span>
            </Button>

            <Button @click="refetch">
                <RefreshCcw class="mr-0 size-4" />
                <span class="hidden md:block">Refrescar</span>
            </Button>
        </template>
    </HeaderComponent>

    <div class="container mx-auto p-6">
        <StatsComponent class="xl:grid-cols-5" :stats="stats" />
        <MachineDataList v-if="machines" :machines="machines" @filtered="filteredMachine = $event" />
    </div>
</template>

<script setup lang="ts">
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue';
import { useGetMachinesList } from '../composables/useGetMachinesList';
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue';
import Button from '~/components/ui/button/Button.vue';
import { AlertTriangle, CircleCheckBig, Cpu, PlusIcon, RefreshCcw, Wrench } from 'lucide-vue-next';
import type { Machine } from '../types/Machine';
import type { StatItem } from '~/components/custom/Stats/StatItem';
import StatsComponent from '~/components/custom/Stats/StatsComponent.vue';
import MachineDataList from '../components/DataList/MachineDataList.vue';
import { hasPermission } from '~/modules/shared/helpers/permissions';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';

const { data: machines, isFetching, suspense, refetch } = useGetMachinesList()

const filteredMachine: Ref<Machine[]> = ref([])

const stats = computed<StatItem[]>(() => {
    const machinesList = machines.value ?? []
    
    const totalmachines = machinesList.length
    const operationalMachines = machinesList.filter((m) => m.status === 'operational').length
    const maintenanceMachines = machinesList.filter((m) => m.status === 'maintenance').length
    const warningMachines = machinesList.filter((m) => m.status === 'warning').length
    const criticalMachines = machinesList.filter((m) => m.status === 'critical').length

    return [
        { title: 'Total Máquinas', icon: Cpu, color: '', value: totalmachines },
        { title: 'Operativos', icon: CircleCheckBig, color: 'text-green-600', value: operationalMachines },
        { title: 'Mantenimiento', icon: Wrench, color: 'text-blue-600', value: maintenanceMachines },
        { title: 'Advertencias', icon: AlertTriangle, color: 'text-yellow-600', value: warningMachines },
        { title: 'Criticos', icon: AlertTriangle, color: 'text-red-600', value: criticalMachines },
    ]
})

onServerPrefetch(async () => {
    await suspense()
})
</script>W

<style scoped></style>

<!-- <template>
    <h2 class="relative scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight transition-colors first:mt-0">
        <span class="flex items-center gap-2">
            <ShieldUser />
            Maquinas
        </span>
        <Motion v-if="isFetching" :initial="{ opacity: 0, height: 0 }" :enter="{ opacity: 1, height: 'auto' }"
            :leave="{ opacity: 0, height: 0 }">
            <Progress class="absolute" indeterminate></Progress>
        </Motion>
    </h2>

    <BackgroundCard title="Lista de Maquinas" :icon="List">
        <DataTableDefault :name="machines!?.length > 1 ? 'maquinas' : 'maquina'"
            :columns="columns({ canView: hasPermission(PERMISSIONS.VIEW_MACHINE), canDelete: hasPermission(PERMISSIONS.DELETE_MACHINE) })"
            :data="machines ?? []" @create="handleCreate = true" :can-create="hasPermission(PERMISSIONS.CREATE_MACHINE)"
            @refresh="refetch" />
    </BackgroundCard>

    <DialogResponsive class="sm:max-w-xl" v-model:open="handleCreate" title="Crear Maquina">
        <AlertMessage v-if="!locations" title="Error"
            message="¡No puedes crear una maquina si no tienes acceso a las ubicaciones!" variant="destructive"
            :icon="AlertCircle" />
        <CreateMachineForm v-else @submit="onCreateMachine" :loading="isPendingCreate" :locations="locations" />
    </DialogResponsive>
</template>

<script setup lang="ts">
import { AlertCircle, List, ShieldUser } from 'lucide-vue-next';
import DataTableDefault from '~/components/custom/DataTable/DataTableDefault.vue';
import BackgroundCard from '~/components/custom/Card/BackgroundCard.vue';
import Progress from '~/components/ui/progress/Progress.vue';
import { columns } from '../components/DataTable/columns';
import DialogResponsive from '~/components/custom/Dialog/DialogResponsive.vue';
import { hasPermission } from '~/modules/shared/helpers/permissions';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';
import { useGetMachinesList } from '../composables/useGetMachinesList';
import { useCreateMachine } from '../composables/useCreateMachine';
import CreateMachineForm from '../components/CreateMachineForm.vue';
import { useGetLocationsList } from '~/modules/location/composables/useGetLocationsList';
import AlertMessage from '~/components/custom/Alert/AlertMessage.vue';

const handleCreate: Ref<boolean> = ref(false);

const { data: machines, isFetching, suspense: suspense, refetch } = useGetMachinesList()
const { data: locations } = useGetLocationsList()

const { mutate: create, isPending: isPendingCreate } = useCreateMachine()

const onCreateMachine = (event: any) => {
    create(event, {
        onSuccess: () => {
            handleCreate.value = false
        }
    })
}

onServerPrefetch(async () => {
    await suspense()
})

</script>

<style scoped></style> -->