<template>
    <LoadingScreen :visible="isFetching" />

    <HeaderComponent title="Gestión de Roles" subtitle="Administra roles de usuario y permisos">
        <template v-slot:buttons>
            <Button @click="navigateTo('roles/new')">
                <PlusIcon class="mr-0 size-4" />
                <span class="hidden lg:block">Nuevo Rol</span>
            </Button>

            <Button @click="refetch">
                <RefreshCcw class="mr-0 size-4" />
                <span class="hidden lg:block">Refrescar</span>
            </Button>
        </template>
    </HeaderComponent>

    <div class="container mx-auto p-6">
        <StatsComponent class="xl:grid-cols-4" v-if="roles" :stats="stats" />
        <RoleDataList v-if="roles" :roles="roles" @filtered="filteredRoles = $event" />
    </div>
</template>

<script setup lang="ts">
import { Key, PlusIcon, RefreshCcw, Shield, UserCheck, Users } from 'lucide-vue-next';
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue';
import Button from '~/components/ui/button/Button.vue';
import { useGetRolesList } from '../composables/useGetRolesList';
import type { Role } from '../types/Role';
import type { StatItem } from '~/components/custom/Stats/StatItem';
import StatsComponent from '~/components/custom/Stats/StatsComponent.vue';
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue';
import RoleDataList from '../components/DataList/RoleDataList.vue';

const { data: roles, isFetching, suspense, refetch } = useGetRolesList()

const filteredRoles: Ref<Role[]> = ref([])

const stats = computed<StatItem[]>(() => {
    const rolesList = roles.value ?? []

    const totalUsersAssigned = rolesList.reduce((acc, role) => acc + role.users_count, 0)
    const totalRoles = rolesList.length
    const activeRoles = rolesList.filter(role => role.is_active).length
    const uniquePermissions = new Set(rolesList.flatMap(role => role.permissions).map(p => p.id))

    return [
        { title: 'Total Roles', icon: Shield, color: '', value: totalRoles },
        { title: 'Usuario Asignados', icon: Users, color: 'text-blue-600', value: totalUsersAssigned },
        { title: 'Permisos Unicos', icon: Key, color: 'text-green-600', value: uniquePermissions.size },
        { title: 'Roles Activos', icon: UserCheck, color: 'text-purple-600', value: activeRoles },
    ]
})

onServerPrefetch(async () => {
    await suspense()
})
</script>

<style scoped></style>