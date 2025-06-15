<template>
    <DataList v-if="locations" :items="locations" :search-keys="['name', 'address', 'description']" :filters="filters"
        :items-per-page-options="[6, 12, 24]" title="Lista de Ubicaciones" @filtered="$emit('filtered', $event)">
        <template #item="{ item }">
            <Card v-for="(location) in item as Location[]" :key="location.id" class="transition-colors hover:bg-muted/50">
                <CardContent>
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                                <component class="size-5" :is="getTypeIcon(location.type)"></component>
                            </div>
                            <div>
                                <h3 class="font-semibold">{{ location.name }}</h3>
                                <p class="text-sm text-muted-foreground">{{ getTypeText(location.type) }}
                                </p>
                            </div>
                        </div>
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Button variant="ghost" size="icon">
                                    <MoreHorizontal class="h-4 w-4" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuItem @click="navigateTo(`locations/${location.id}`)">Ver perfil
                                </DropdownMenuItem>
                                <DropdownMenuItem @click="setEditMode(true); navigateTo(`users/${location.id}`)">Editar
                                    ubicación</DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem @click="destroy(location.id)" class="text-destructive">
                                    Eliminar</DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>

                    <div class="space-y-3 mb-4">
                        <p class="text-sm text-muted-foreground">{{ location.description }}</p>
                        <div class="flex items-center gap-2 text-sm">
                            <MapPin class="h-4 w-4 text-muted-foreground" />
                            <span class="truncate">{{ location.address }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <Users class="h-4 w-4 text-muted-foreground" />
                            <span>Responsable: {{ location.manager_name }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <Badge :class="getStatusColor(location.is_active)">{{ getStatusText(location.is_active) }}
                        </Badge>
                    </div>

                    <div class="grid grid-cols-3 gap-2 mt-4 pt-4 border-t">
                        <div class="text-center">
                            <div class="font-medium text-blue-600">{{ location.machines.length }}</div>
                            <div class="text-xs text-muted-foreground">Equipos</div>
                        </div>
                        <div class="text-center">
                            <div class="font-medium text-orange-600">{{location.work_orders.filter(wo => wo.status
                                === 'in_progress').length}}</div>
                            <div class="text-xs text-muted-foreground">OT Activas</div>
                        </div>
                        <div class="text-center">
                            <div class="font-medium text-green-600">{{ location.work_orders.length }}</div>
                            <div class="text-xs text-muted-foreground">OT Total</div>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t">
                        <div class="flex justify-between text-xs text-muted-foreground">
                            <div>Creado: {{ location.created_at }}</div>
                            <div>Actualizado: {{ location.updated_at }}</div>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </template>
    </DataList>
</template>

<script setup lang="ts">
import { Building, Cpu, Factory, Home, MapPin, MoreHorizontal, Users, Warehouse } from 'lucide-vue-next';
import Card from '~/components/ui/card/Card.vue';
import CardContent from '~/components/ui/card/CardContent.vue';
import DropdownMenu from '~/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '~/components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import Button from '~/components/ui/button/Button.vue';
import DropdownMenuContent from '~/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '~/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuSeparator from '~/components/ui/dropdown-menu/DropdownMenuSeparator.vue';
import Badge from '~/components/ui/badge/Badge.vue';
import { filters } from './filters';
import DataList from '~/components/custom/DataList/DataList.vue';
import { useDeleteLocation } from '../../composables/useDeleteLocation';
import type { Location } from '../../types/Location';

const { setEditMode } = useEditMode()

const { mutate: destroy } = useDeleteLocation()

const props = defineProps<{
    locations: Location[]
}>()

const getStatusColor = (status: boolean) => {
    switch (status) {
        case true:
            return "bg-green-100 text-green-800 border-green-200"
        case false:
            return "bg-red-100 text-red-800 border-red-200"
        default:
            return "bg-gray-100 text-gray-800 border-gray-200"
    }
}

const getStatusText = (status: boolean) => {
    switch (status) {
        case true:
            return "Activo"
        case false:
            return "Inactivo"
        default:
            return status
    }
}

const getTypeIcon = (type: string) => {
    switch (type) {
        case "building":
        case "floor":
        case "rooftop":
            return Building;
        case "room":
            return Home;
        case "warehouse":
            return Warehouse;
        case "datacenter":
            return Cpu;
        case "outdoor":
            return MapPin;
        case "parking":
            return Factory;
        default:
            return MapPin;
    }
};

const getTypeText = (type: string) => {
    switch (type) {
        case "building":
            return "Edificio"
        case "room":
            return "Sala"
        case "floor":
            return "Planta"
        case "warehouse":
            return "Almacén"
        case "datacenter":
            return "Centro de Datos"
        case "outdoor":
            return "Exterior"
        case "parking":
            return "Parking"
        case "rooftop":
            return "Azotea"
        default:
            return type
    }
}

</script>

<style scoped></style>