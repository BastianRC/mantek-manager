<template>
    <TooltipProvider>
        <Tooltip>
            <TooltipTrigger type="button">
                <component :is="icon || AlertCircle" class="size-4 text-yellow-600"></component>
            </TooltipTrigger>
            <TooltipContent>
                <p>{{ message }}</p>
            </TooltipContent>
        </Tooltip>
    </TooltipProvider>
</template>

<script setup lang="ts">
import { AlertCircle, type LucideIcon } from 'lucide-vue-next';
import Tooltip from '~/components/ui/tooltip/Tooltip.vue';
import TooltipContent from '~/components/ui/tooltip/TooltipContent.vue';
import TooltipProvider from '~/components/ui/tooltip/TooltipProvider.vue';
import TooltipTrigger from '~/components/ui/tooltip/TooltipTrigger.vue';

defineProps<{
    message: string,
    icon?: LucideIcon
}>()
</script>

<style scoped></style>