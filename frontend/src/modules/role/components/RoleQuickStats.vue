<template>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <Users class="h-4 w-4 text-muted-foreground" />
            <span class="text-sm">Usuarios asignados</span>
        </div>
        <span class="font-medium">{{ role.users ? role.users.length : 0 }}</span>
    </div>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <Key class="h-4 w-4 text-muted-foreground" />
            <span class="text-sm">Permisos totales</span>
        </div>
        <span class="font-medium">{{ role.permissions.length }}</span>
    </div>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <Shield class="h-4 w-4 text-muted-foreground" />
            <span class="text-sm">Nivel de acceso</span>
        </div>
        <span class="text-sm">{{ getLevel(total, role.permissions.length) }}</span>
    </div>
</template>

<script setup lang="ts">
import { Key, Shield, Users } from 'lucide-vue-next';
import type { RoleDetails } from '../types/RoleDetails';
import { useGetRolesList } from '../composables/useGetRolesList';

defineProps<{
    role: RoleDetails,
    total: number
}>()

const getLevel = (total: number, current: number): 'Bajo' | 'Medio' | 'Alto' | 'Total' =>
    current === total ? 'Total' : current <= total / 3 ? 'Bajo' : current <= (2 * total) / 3 ? 'Medio' : 'Alto';
</script>

<style scoped></style>