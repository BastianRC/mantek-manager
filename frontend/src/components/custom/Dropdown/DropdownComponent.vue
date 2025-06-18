<template>
    <DropdownMenu v-if="visibleItems.length !== 0">
        <DropdownMenuTrigger asChild>
            <Button variant="ghost" size="icon">
                <MoreHorizontal class="size-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <template v-for="(item, index) in visibleItems" :key="index">
                <DropdownMenuSeparator v-if="item.separatorBefore" />
                <DropdownMenuItem @click="item.click()" :class="item.class">
                    {{ item.text }}
                </DropdownMenuItem>
            </template>

        </DropdownMenuContent>
    </DropdownMenu>

</template>

<script setup lang="ts">
import { MoreHorizontal } from 'lucide-vue-next';
import Button from '~/components/ui/button/Button.vue';
import DropdownMenu from '~/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuContent from '~/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '~/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuSeparator from '~/components/ui/dropdown-menu/DropdownMenuSeparator.vue';
import DropdownMenuTrigger from '~/components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import { hasPermission } from '~/modules/shared/helpers/permissions';

export type DropdownButtons = {
    text: string
    click: () => void
    class?: string
    separatorBefore?: boolean,
    canView: string
}

const props = defineProps<{
    items: DropdownButtons[]
}>()

const visibleItems = computed(() => props.items.filter(item => hasPermission(item.canView) !== false))

</script>

<style scoped></style>
