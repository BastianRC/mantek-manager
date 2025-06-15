<template>
    <DataList v-if="users" :items="users" :search-keys="['first_name', 'last_name', 'email', 'department']"
        :filters="filters" :items-per-page-options="[6, 12, 24]" title="Lista de Usuarios"
        @filtered="$emit('filtered', $event)">
        <template #item="{ item }">
            <Card v-for="(user) in item" :key="user.id" class="transition-colors hover:bg-muted/50 py-0">
                <CardContent class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <Avatar class="size-12">
                                <AvatarImage :src="user.avatar_url ?? ''"></AvatarImage>
                                <AvatarFallback>{{ getInitials(`${user.first_name} ${user.last_name}`) }}
                                </AvatarFallback>
                            </Avatar>
                            <div>
                                <h3 class="font-semibold">{{ `${user.first_name} ${user.last_name}` }}</h3>
                                <div class="flex items-center gap-1 text-sm text-muted-foreground">
                                    <Users class="size-4" />
                                    {{ user.role }}
                                </div>
                            </div>
                        </div>
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Button variant="ghost" size="icon">
                                    <MoreHorizontal class="size-4" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuItem @click="navigateTo(`users/${user.id}`)">Ver perfil</DropdownMenuItem>
                                <DropdownMenuItem
                                    @click="setEditMode(true); navigateTo(`users/${user.id}`)">
                                    Editar usuario</DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem @click="destroy(user.id)" class="text-destructive">
                                    Eliminar
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center gap-2 text-sm">
                            <Mail class="size-4 text-muted-foreground" />
                            <span class="truncate">{{ user.email }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <Phone class="size-4 text-muted-foreground" />
                            <span>{{ user.phone }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <Calendar class="size-4 text-muted-foreground" />
                            <span>Último acceso: {{ user.last_login ?? 'Desconocido' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <Badge :class="getStatusColor(user.is_active)">{{ getStatusText(user.is_active) }}
                        </Badge>
                        <span class="text-sm text-muted-foreground">{{ user.department }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <div class="text-lg font-bold">{{ 0 }}</div>
                            <div class="text-xs text-muted-foreground">Órdenes asignadas</div>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-green-600">{{ 0 }}</div>
                            <div class="text-xs text-muted-foreground">Completadas</div>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </template>
    </DataList>
</template>

<script setup lang="ts">
import { Calendar, Mail, MoreHorizontal, Phone, Users } from 'lucide-vue-next';
import Card from '~/components/ui/card/Card.vue';
import CardContent from '~/components/ui/card/CardContent.vue';
import type { User } from '../../types/User';
import Avatar from '~/components/ui/avatar/Avatar.vue';
import AvatarImage from '~/components/ui/avatar/AvatarImage.vue';
import AvatarFallback from '~/components/ui/avatar/AvatarFallback.vue';
import { getInitials } from '~/lib/utils';
import DropdownMenu from '~/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '~/components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import Button from '~/components/ui/button/Button.vue';
import DropdownMenuContent from '~/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '~/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuSeparator from '~/components/ui/dropdown-menu/DropdownMenuSeparator.vue';
import Badge from '~/components/ui/badge/Badge.vue';
import { filters } from './filters';
import DataList from '~/components/custom/DataList/DataList.vue';
import { useDeleteUser } from '../../composables/useDeleteUser';

const { setEditMode } = useEditMode()

const { mutate: destroy } = useDeleteUser()

const props = defineProps<{
    users: User[]
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

</script>

<style scoped></style>