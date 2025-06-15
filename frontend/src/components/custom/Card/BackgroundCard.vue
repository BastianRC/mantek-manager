<template>
    <Card class="gap-2 border-none">
        <CardHeader>
            <CardTitle class="scroll-m-20 text-xl font-semibold tracking-tight">
                <span class="flex items-center gap-2">
                    <component :is="icon"></component>
                    {{ title }}
                </span>
            </CardTitle>
        </CardHeader>
        <CardContent class="flex-1">
            <slot />
        </CardContent>
    </Card>
</template>

<script setup lang="ts">
import type { Component } from 'vue';
import Card from '~/components/ui/card/Card.vue';
import CardContent from '~/components/ui/card/CardContent.vue';
import CardHeader from '~/components/ui/card/CardHeader.vue';
import CardTitle from '~/components/ui/card/CardTitle.vue';
import Progress from '~/components/ui/progress/Progress.vue';

defineProps<{
  title: string
  icon?: Component
}>()

</script>

<style scoped></style>