<template>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <Cpu class="h-4 w-4 text-muted-foreground" />
            <span class="text-sm">Maquinas</span>
        </div>
        <span class="font-medium">{{ location.machines.length }}</span>
    </div>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <Wrench class="h-4 w-4 text-muted-foreground" />
            <span class="text-sm">OT Activas</span>
        </div>
        <span class="font-medium">{{ location.work_orders.filter(w => w.status === 'in_progress').length }}</span>
    </div>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <CheckCircle class="h-4 w-4 text-muted-foreground" />
            <span class="text-sm">OT Totales</span>
        </div>
        <span class="font-medium">{{ location.work_orders.length }}</span>
    </div>
</template>

<script setup lang="ts">
import { CheckCircle, Cpu, Wrench } from 'lucide-vue-next';
import type { LocationDetails } from '../types/LocationDetails';

const props = defineProps<{
    location: LocationDetails,
}>()
</script>

<style scoped></style>