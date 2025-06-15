<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton size="lg"
                        class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                        <Avatar class="size-10 rounded-full">
                            <AvatarImage :src="user.avatar" :alt="user.name" />
                            <AvatarFallback class="rounded-lg">
                                {{ getInitials(user.name) }}
                            </AvatarFallback>
                        </Avatar>
                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">{{ user.name }}</span>
                            <span class="truncate text-xs">{{ user.email }}</span>
                        </div>
                        <ChevronsUpDown class="ml-auto size-4" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent class="w-[--reka-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                    :side="isMobile ? 'bottom' : 'right'" align="end" :side-offset="4">
                    <DropdownMenuLabel class="p-0 font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <Avatar class="size-10 rounded-full">
                                <AvatarImage :src="user.avatar" :alt="user.name" />
                                <AvatarFallback class="rounded-lg">{{ getInitials(user.name) }}</AvatarFallback>
                            </Avatar>
                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ user.name }}</span>
                                <span class="truncate text-xs">{{ user.email }}</span>
                            </div>
                        </div>
                    </DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem @click="logout">
                        <LogOut />
                        Log out
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
</template>

<script setup lang="ts">
import { BadgeCheck, Bell, ChevronsUpDown, CreditCard, LogOut, Sparkles } from 'lucide-vue-next';
import Avatar from '~/components/ui/avatar/Avatar.vue';
import AvatarFallback from '~/components/ui/avatar/AvatarFallback.vue';
import AvatarImage from '~/components/ui/avatar/AvatarImage.vue';
import DropdownMenu from '~/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuContent from '~/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuGroup from '~/components/ui/dropdown-menu/DropdownMenuGroup.vue';
import DropdownMenuItem from '~/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuLabel from '~/components/ui/dropdown-menu/DropdownMenuLabel.vue';
import DropdownMenuSeparator from '~/components/ui/dropdown-menu/DropdownMenuSeparator.vue';
import DropdownMenuTrigger from '~/components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import { useSidebar } from '~/components/ui/sidebar';
import SidebarMenu from '~/components/ui/sidebar/SidebarMenu.vue';
import SidebarMenuButton from '~/components/ui/sidebar/SidebarMenuButton.vue';
import SidebarMenuItem from '~/components/ui/sidebar/SidebarMenuItem.vue';
import { getInitials } from '~/lib/utils';
import { useLogout } from '~/modules/auth/composables/useLogout';

const props = defineProps<{
    user: {
        name: string
        email: string
        avatar: string
    }
}>()

const { isMobile } = useSidebar()

const { mutate: logout } = useLogout()

</script>

<style scoped></style>