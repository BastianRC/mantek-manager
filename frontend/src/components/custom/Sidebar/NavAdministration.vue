<template>
    <SidebarGroup v-if="visibleItems.length !== 0">
        <SidebarGroupLabel>Administración</SidebarGroupLabel>
        <SidebarMenu>
            <template v-for="item in visibleItems" :key="item.title">
                <Collapsible v-if="item.isCollapsable" as-child :default-open="item.isOpen" class="group/collapsible">
                    <SidebarMenuItem>
                        <CollapsibleTrigger as-child>
                            <SidebarMenuButton :tooltip="item.title">
                                <component :is="item.icon" v-if="item.icon" />
                                <span>{{ item.title }}</span>
                                <ChevronRight
                                    class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                            </SidebarMenuButton>
                        </CollapsibleTrigger>

                        <CollapsibleContent>
                            <SidebarMenuSub>
                                <SidebarMenuSubItem v-for="subItem in item.items" :key="subItem.title">
                                    <SidebarMenuSubButton as-child>
                                        <a :href="subItem.url">
                                            <span>{{ subItem.title }}</span>
                                        </a>
                                    </SidebarMenuSubButton>
                                </SidebarMenuSubItem>
                            </SidebarMenuSub>
                        </CollapsibleContent>
                    </SidebarMenuItem>
                </Collapsible>
                <SidebarMenuItem v-else>
                    <SidebarMenuButton :tooltip="item.title" as-child>
                        <a :href="item.url">
                            <component :is="item.icon" v-if="item.icon" />
                            <span>{{ item.title }}</span>
                        </a>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </template>
        </SidebarMenu>
    </SidebarGroup>

</template>

<script setup lang="ts">
import { ChevronRight, type LucideIcon } from 'lucide-vue-next';
import Collapsible from '~/components/ui/collapsible/Collapsible.vue';
import CollapsibleContent from '~/components/ui/collapsible/CollapsibleContent.vue';
import CollapsibleTrigger from '~/components/ui/collapsible/CollapsibleTrigger.vue';
import SidebarGroup from '~/components/ui/sidebar/SidebarGroup.vue';
import SidebarGroupLabel from '~/components/ui/sidebar/SidebarGroupLabel.vue';
import SidebarMenu from '~/components/ui/sidebar/SidebarMenu.vue';
import SidebarMenuButton from '~/components/ui/sidebar/SidebarMenuButton.vue';
import SidebarMenuItem from '~/components/ui/sidebar/SidebarMenuItem.vue';
import SidebarMenuSub from '~/components/ui/sidebar/SidebarMenuSub.vue';
import SidebarMenuSubButton from '~/components/ui/sidebar/SidebarMenuSubButton.vue';
import SidebarMenuSubItem from '~/components/ui/sidebar/SidebarMenuSubItem.vue';

type SidebarSubItem = {
    title: string
    url: string
    canView?: boolean
}

type SidebarItem =
    | {
        title: string
        icon?: LucideIcon
        isActive?: boolean
        isCollapsable: true
        isOpen?: boolean
        items: SidebarSubItem[],
        canView?: boolean
    }
    | {
        title: string
        icon?: LucideIcon
        isActive?: boolean
        url: string
        isCollapsable?: false
        canView?: boolean
    }

const props = defineProps<{
    items: SidebarItem[]
}>()

const visibleItems = computed(() => props.items.filter(item => item.canView !== false))

</script>

<style scoped></style>