<template>
    <DataList v-if="machines" :items="machines" :search-keys="['name', 'machine_model', 'serial_number']"
        :filters="filters" :items-per-page-options="[6, 12, 24]" title="Lista de Máquinas"
        @filtered="$emit('filtered', $event)">
        <template #item="{ item }">
            <Card v-for="(machine) in item as Machine[]" :key="machine.id" class="transition-colors hover:bg-muted/50">
                <CardContent>
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="font-semibold mb-1">{{ machine.name }}</h3>
                            <p class="text-sm text-muted-foreground">{{ machine.type.name }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <Badge :class="`${getStatusMeta(machine.status).color} border`">
                                    <component :is="getStatusMeta(machine.status).icon" />
                                    <span class="ml-1">{{ getStatusMeta(machine.status).label }}</span>
                                </Badge>
                            </div>
                        </div>

                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Button variant="ghost" size="icon">
                                    <MoreHorizontal class="size-4" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuItem @click="navigateTo(`machines/${machine.id}`)">Ver perfil
                                </DropdownMenuItem>
                                <DropdownMenuItem @click="setEditMode(true); navigateTo(`machines/${machine.id}`)">
                                    Editar equipo</DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem @click="destroy(machine.id)" class="text-destructive">Dar de baja
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>

                    <div class="space-y-3 mb-4">
                        <div class="flex items-center gap-2 text-sm">
                            <MapPin class="size-4 text-muted-foreground" />
                            <span class="truncate">{{ machine.location.name }}</span>
                        </div>
                        <!-- TODO: ESTO SE AÑADIRA CUANDO SE AÑADA EL MODULO DE MANTENIMIENTO -->
                        <!-- <div class="flex items-center gap-2 text-sm">
                            <Calendar class="size-4 text-muted-foreground" />
                            <span>
                                Próximo mantenimiento:
                                <span :class="getMaintenanceStatusMeta(machine.next_maintenance).color">
                                    {{ getMaintenanceStatusMeta(machine.next_maintenance).label }}
                                </span>
                            </span>
                        </div> -->
                    </div>

                    <div class="mt-4 pt-4 border-t">
                        <div class="flex justify-between text-xs text-muted-foreground">
                            <div>Creado: {{ machine.created_at }}</div>
                            <div>Actualizado: {{ machine.updated_at }}</div>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </template>
    </DataList>
</template>

<script setup lang="ts">
import { Building, Calendar, Cpu, MapPin, MoreHorizontal } from 'lucide-vue-next';
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
import type { Machine } from '../../types/Machine';
import { useDeleteMachine } from '../../composables/useDeleteMachine';
import { getStatusMeta } from '../../utils/getStatusMeta';

const { setEditMode } = useEditMode()

const { mutate: destroy } = useDeleteMachine()

const props = defineProps<{
    machines: Machine[]
}>()

</script>

<style scoped></style>