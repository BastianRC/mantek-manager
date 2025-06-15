<template>
    <Alert :variant="variant" :class="{ 'border-[var(--destructive)]': variant === 'destructive' }">
        <component :is="icon" class="size-4" />
        <AlertTitle>{{ title }}</AlertTitle>
        <AlertDescription>
            {{ message }}
        </AlertDescription>
    </Alert>
</template>

<script setup lang="ts">
import { type LucideIcon } from 'lucide-vue-next';
import Alert from '~/components/ui/alert/Alert.vue';
import AlertDescription from '~/components/ui/alert/AlertDescription.vue';
import AlertTitle from '~/components/ui/alert/AlertTitle.vue';

defineProps<{
    title: string,
    message: string,
    variant?: 'destructive' | 'default'
    icon?: LucideIcon
}>()
</script>

<style scoped></style>