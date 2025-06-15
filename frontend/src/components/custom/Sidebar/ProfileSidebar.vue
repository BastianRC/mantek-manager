<template>
    <SidebarProvider class="items-start min-h-none gap-5">
        <Sidebar collapsible="none"
            class="hidden bg-white rounded-xl px-2 py-3 shadow md:flex md:w-16 md:items-center lg:w-60 lg:items-stretch">
            <SidebarContent>
                <SidebarGroup>
                    <SidebarGroupContent>
                        <SidebarMenu>
                            <SidebarMenuItem v-for="item in items" :key="item.name">
                                <SidebarMenuButton as-child :tooltip="item.name">
                                    <a href="#">
                                        <component :is="item.icon" />
                                        <span class="hidden lg:inline">{{ item.name }}</span>
                                    </a>
                                </SidebarMenuButton>
                            </SidebarMenuItem>
                        </SidebarMenu>
                    </SidebarGroupContent>
                </SidebarGroup>
            </SidebarContent>
        </Sidebar>
        <main class="flex flex-1 flex-col">
            <slot />
        </main>
    </SidebarProvider>
</template>

<script setup lang="ts">
import {
    SidebarProvider,
    Sidebar,
    SidebarContent,
    SidebarGroup,
    SidebarGroupContent,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from "@/components/ui/sidebar"
import type { LucideIcon } from "lucide-vue-next";

defineProps<{
    items: { name: string, icon: LucideIcon, url: string }[]    
}>()

</script>

<style scoped></style>