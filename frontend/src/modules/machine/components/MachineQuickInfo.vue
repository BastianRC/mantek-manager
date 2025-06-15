<template>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <MapPin class="size-4 text-muted-foreground" />
            <span class="text-sm">Ubicación</span>
        </div>
        <span class="text-sm font-medium">{{ machine.location.name }}</span>
    </div>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <Calendar class="size-4 text-muted-foreground" />
            <span class="text-sm">Instalación</span>
        </div>
        <span class="text-sm">{{ machine.install_date }}</span>
    </div>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <Wrench class="size-4 text-muted-foreground" />
            <span class="text-sm">Órdenes de trabajo</span>
        </div>
        <span class="text-sm">{{ machine.work_orders.length }}</span>
    </div>
</template>

<script setup lang="ts">
import { Calendar, MapPin, Wrench } from 'lucide-vue-next';
import type { MachineDetails } from '../types/MachineDetails';


defineProps<{
    machine: MachineDetails
}>()
</script>

<style scoped></style>