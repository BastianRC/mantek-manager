<template>
    <div v-if="chronologies?.length !== 0" class="space-y-4">
        <div v-for="(chronology, index) in chronologies" :key="index" class="flex gap-3">
            <div class="flex flex-col items-center">
                <div class="p-2 bg-background border rounded-full">
                    <component class="!bg-transparent border-none"
                        :class="`${getChronologyEventMeta(chronology.event_type).color} size-4`"
                        :is="getChronologyEventMeta(chronology.event_type).icon"></component>
                </div>
            </div>

            <div class="flex-1 pb-4">
                <div class="flex items-center gap-2 mb-1">
                    <span class="font-medium text-sm">{{ chronology.description }}</span>
                    <span class="text-xs text-muted-foreground">{{ chronology.created_at }}</span>
                </div>
                <p class="text-sm text-muted-foreground">Por: {{ chronology.user.name }}</p>
            </div>
        </div>
    </div>

    <AlertMessage v-else title="¡Sin resultados!" message="No se ha encontrado la cronologia de este elemento"
        :icon="AlertCircle" />
</template>

<script setup lang="ts">
import AlertMessage from '~/components/custom/Alert/AlertMessage.vue';
import { useChronology } from '../composables/useChronology';
import { getChronologyEventMeta } from '../utils/getChronologyTypeMeta';
import { AlertCircle } from 'lucide-vue-next';
import type { Chronology } from '../types/Chronology';

defineProps<{
    chronologies: Chronology[]
}>()
</script>

<style scoped></style>