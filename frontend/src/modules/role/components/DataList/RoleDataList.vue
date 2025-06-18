<template>
    <DataList v-if="roles" :items="roles" :search-keys="['name', 'description']" :filters="filters"
        :items-per-page-options="[6, 12, 24]" title="Lista de Roles" @filtered="$emit('filtered', $event)">
        <template #item="{ item }">
            <Card v-for="(role) in item as Role[]" :key="role.id" class="transition-colors hover:bg-muted/50 py-0">
                <CardContent class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg" :class="getColorClasses(role.color)">
                                <Shield class="size-5" />
                            </div>
                            <div>
                                <h3 class="font-semibold">{{ role.name }}</h3>
                                <p class="text-sm text-muted-foreground">{{ role.users.length }} Usuario/s</p>
                            </div>
                        </div>

                        <DropdownComponent :items="getDropdownItems(role)" />
                    </div>

                    <p class="text-sm text-muted-foreground mb-4">{{ role.description }}</p>

                    <div class="space-y-3">
                        <div>
                            <h4 class="text-sm font-medium mb-2">Permisos ({{ role.permissions.length }})</h4>
                            <div class="space-y-1 max-h-32 overflow-y-auto">
                                <div v-for="(permission) in role.permissions.slice(0, 5)" :key="permission.id"
                                    class="flex items-center gap-2 text-xs">
                                    <Key class="size-3 text-muted-foreground" />
                                    <span class="truncate">{{ permission.name }}</span>
                                </div>

                                <div v-if="role.permissions.length > 5" class="text-xs text-muted-foreground">
                                    +{{ role.permissions.length - 5 }} permisos más
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-t">
                            <div class="flex justify-between text-xs text-muted-foreground">
                                <span>Creado: {{ role.created_at }}</span>
                                <span>Actualizado: {{ role.updated_at }}</span>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </template>
    </DataList>
</template>

<script setup lang="ts">
import { Key, Shield } from 'lucide-vue-next';
import Card from '~/components/ui/card/Card.vue';
import CardContent from '~/components/ui/card/CardContent.vue';
import { filters } from './filters';
import DataList from '~/components/custom/DataList/DataList.vue';
import type { Role } from '../../types/Role';
import { useDeleteRole } from '../../composables/useDeleteRole';
import type { DropdownButtons } from '~/components/custom/Dropdown/DropdownComponent.vue';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';
import DropdownComponent from '~/components/custom/Dropdown/DropdownComponent.vue';

const { setEditMode } = useEditMode()

const { mutate: destroy } = useDeleteRole()

const props = defineProps<{
    roles: Role[]
}>()

function getDropdownItems(role: Role): DropdownButtons[] {
    return [
        {
            text: 'Ver perfil',
            click: () => navigateTo(`roles/${role.id}`),
            canView: PERMISSIONS.VIEW_ROLE
        },
        {
            text: 'Editar rol',
            click: () => {
                setEditMode(true)
                navigateTo(`roles/${role.id}`)
            },
            canView: PERMISSIONS.UPDATE_ROLE
        },
        {
            text: 'Eliminar',
            click: () => destroy(role.id),
            class: 'text-destructive',
            separatorBefore: true,
            canView: PERMISSIONS.DELETE_ROLE
        }
    ]
}

const getColorClasses = (color: string) => {
    const colors = {
        purple: "bg-purple-100 text-purple-800 border-purple-200",
        blue: "bg-blue-100 text-blue-800 border-blue-200",
        green: "bg-green-100 text-green-800 border-green-200",
        orange: "bg-orange-100 text-orange-800 border-orange-200",
        gray: "bg-gray-100 text-gray-800 border-gray-200",
        slate: "bg-slate-100 text-slate-800 border-slate-200",
    }
    return colors[color as keyof typeof colors] || colors.gray
}

</script>

<style scoped></style>