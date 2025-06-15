<template>
    <LoadingScreen :visible="isFetching" />

    <HeaderComponent title="Gestión de Usuarios" subtitle="Administra usuarios, roles y permisos">
        <template v-slot:buttons>
            <Button @click="navigateTo('users/new')">
                <PlusIcon class="mr-0 size-4" />
                <span class="hidden md:block">Nuevo Usuario</span>
            </Button>

            <Button @click="refetch">
                <RefreshCcw class="mr-0 size-4" />
                <span class="hidden md:block">Refrescar</span>
            </Button>
        </template>
    </HeaderComponent>

    <div class="container mx-auto p-6">
        <StatsComponent v-if="users" :stats="stats" />
        <UserDataList v-if="users" :users="users" @filtered="filteredUsers = $event" />
    </div>
</template>

<script setup lang="ts">
import { PlusIcon, RefreshCcw, UserCheck, UserPlus, Users, UserX } from 'lucide-vue-next';
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue';
import StatsComponent from '~/components/custom/Stats/StatsComponent.vue';
import { useGetUsersList } from '../composables/useGetUsersList';
import type { StatItem } from '~/components/custom/Stats/StatItem';
import type { User } from '../types/User';
import UserDataList from '../components/DataList/UserDataList.vue';
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue';
import Button from '~/components/ui/button/Button.vue';

const { data: users, isFetching, suspense, refetch } = useGetUsersList()

const filteredUsers: Ref<User[]> = ref([])

const stats = computed<StatItem[]>(() => {
    const usersList = users.value ?? []

    const getCount = (filter?: (u: User) => boolean) =>
        filter ? usersList.filter(filter).length : usersList.length

    return [
        { title: 'Total Usuarios', icon: Users, color: '', value: getCount() },
        { title: 'Activos', icon: UserCheck, color: 'text-green-600', value: getCount(u => u.is_active) },
        { title: 'Inactivos', icon: UserX, color: 'text-red-600', value: getCount(u => !u.is_active) },
    ]
})

onServerPrefetch(async () => {
    await suspense()
})
</script>

<style scoped></style>