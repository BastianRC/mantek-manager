<template>
    <Sidebar v-bind="props" class="shadow-xl">
        <SidebarContent>
            <NavAdministration :items="data.navAdministration" />
            <NavAssets :items="data.navAssets" />
            <NavTools :items="data.navTools" />
        </SidebarContent>
        <SidebarFooter>
            <NavUser :user="{ name: authStore.user?.name ?? '', email: authStore.user?.email ?? '', avatar: '' }" />
        </SidebarFooter>
    </Sidebar>
</template>

<script setup lang="ts">
import { Boxes, BriefcaseBusiness, Clock, Locate, ShieldUser, Users2 } from 'lucide-vue-next';
import type { SidebarProps } from '~/components/ui/sidebar';
import Sidebar from '~/components/ui/sidebar/Sidebar.vue';
import SidebarContent from '~/components/ui/sidebar/SidebarContent.vue';
import NavAdministration from './NavAdministration.vue';
import NavUser from './NavUser.vue';
import SidebarFooter from '~/components/ui/sidebar/SidebarFooter.vue';
import { useAuthStore } from '~/modules/auth/stores/auth';
import { hasPermission } from '~/modules/shared/helpers/permissions';
import { PERMISSIONS } from '~/modules/shared/constants/permissions';
import NavAssets from './NavAssets.vue';
import NavTools from './NavTools.vue';

const props = withDefaults(defineProps<SidebarProps>(), {
    collapsible: 'icon',
})

const authStore = useAuthStore()

const data = {
    navAdministration: [
        {
            title: 'Usuarios',
            url: '/dashboard/users',
            icon: Users2,
            isActive: true,
            canView: hasPermission(PERMISSIONS.VIEW_ALL_USERS)
        },

        {
            title: 'Roles',
            url: '/dashboard/roles',
            icon: ShieldUser,
            isActive: true,
            canView: hasPermission(PERMISSIONS.VIEW_ALL_ROLES)
        },

        {
            title: 'Ubicaciones',
            url: '/dashboard/locations',
            icon: Locate,
            isActive: true,
            canView: hasPermission(PERMISSIONS.VIEW_ALL_LOCATIONS)
        }
    ],

    navAssets: [
        {
            title: 'Maquinas',
            url: '/dashboard/machines',
            icon: Boxes,
            isActive: true,
            canView: hasPermission(PERMISSIONS.VIEW_ALL_MACHINES)
        },

        {
            title: 'Órdenes de Trabajo',
            url: '/dashboard/work-orders',
            icon: BriefcaseBusiness,
            isActive: true,
            canView: hasPermission(PERMISSIONS.VIEW_ALL_MACHINES)
        }
    ],

    navTools: [
        {
            title: 'Cronologia',
            url: '/dashboard/chronologies',
            icon: Clock,
            isActive: true,
            canView: hasPermission(PERMISSIONS.VIEW_ALL_CHRONOLOGIES)
        },
    ]
}

</script>

<style scoped></style>