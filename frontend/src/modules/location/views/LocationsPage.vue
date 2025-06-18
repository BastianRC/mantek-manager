<template>
    <LoadingScreen :visible="isFetching" />

    <HeaderComponent title="Gestión de Ubicaciones" subtitle="Administra todas las ubicaciones y zonas">
        <template v-slot:buttons>
            <Button v-if="hasPermission(PERMISSIONS.CREATE_LOCATION)" @click="navigateTo('locations/new')">
                <PlusIcon class="mr-0 size-4" />
                <span class="hidden md:block">Nuevo Ubicación</span>
            </Button>

            <Button @click="refetch">
                <RefreshCcw class="mr-0 size-4" />
                <span class="hidden md:block">Refrescar</span>
            </Button>
        </template>
    </HeaderComponent>

    <div class="container mx-auto p-6">
        <StatsComponent class="xl:grid-cols-4" :stats="stats" />
        <LocationDataList v-if="locations" :locations="locations" @filtered="filteredLocation = $event" />
    </div>
</template>

<script setup lang="ts">
import { CircleCheckBig, Cpu, MapPin, PlusIcon, RefreshCcw, Wrench } from 'lucide-vue-next';
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue';
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue';
import Button from '~/components/ui/button/Button.vue';
import { useGetLocationsList } from '../composables/useGetLocationsList';
import type { StatItem } from '~/components/custom/Stats/StatItem';
import type { Location } from '../types/Location';
import StatsComponent from '~/components/custom/Stats/StatsComponent.vue';
import LocationDataList from '../components/DataList/LocationDataList.vue';
import { hasPermission } from '~/modules/shared/helpers/permissions';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';

const { data: locations, isFetching, suspense, refetch } = useGetLocationsList()

const filteredLocation: Ref<Location[]> = ref([])

const stats = computed<StatItem[]>(() => {
    const locationList = locations.value ?? []
    
    const totalLocations = locationList.length
    const activeLocations = locationList.filter(location => location.is_active).length
    const totalMachines = locationList.flatMap(location => location.machines).length;
    const totalWorkOrdersActive = locationList.flatMap(loc => loc.work_orders ?? []).filter(w => w.status === 'in_progress').length;

    return [
        { title: 'Total Ubicaciones', icon: MapPin, color: '', value: totalLocations },
        { title: 'Activas', icon: CircleCheckBig, color: 'text-green-600', value: activeLocations },
        { title: 'Equipos Totales', icon: Cpu, color: 'text-blue-600', value: totalMachines },
        { title: 'OT Activas', icon: Wrench, color: 'text-red-600', value: totalWorkOrdersActive },
    ]
})


onServerPrefetch(async () => {
    await suspense()
})
</script>

<style scoped></style>