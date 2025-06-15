<template>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mb-8">
        <Card v-for="(stat, index) in stats" :key="index">
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-md font-medium">{{ stat.title }}</CardTitle>
                <component :is="stat.icon" class="size-6" :class="stat.color ? stat.color : 'text-muted-foreground'" />
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold" :class="stat.color">{{ stat.value }}</div>
            </CardContent>
        </Card>
    </div>
</template>

<script setup lang="ts">
import type { LucideIcon } from 'lucide-vue-next';
import Card from '~/components/ui/card/Card.vue';
import CardContent from '~/components/ui/card/CardContent.vue';
import CardHeader from '~/components/ui/card/CardHeader.vue';
import CardTitle from '~/components/ui/card/CardTitle.vue';
import type { StatItem } from './StatItem';

defineProps<{
    stats: StatItem[]
}>()

</script>

<style scoped></style>