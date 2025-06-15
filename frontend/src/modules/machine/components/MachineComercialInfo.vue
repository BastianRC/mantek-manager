<template>
    <div class="flex items-center justify-between">
        <span class="text-sm">Garantía hasta</span>
        <span class="text-sm">{{ machine.warranty_expiry ?? '---' }}</span>
    </div>
    <div class="flex items-center justify-between">
        <span class="text-sm">Proveedor</span>
        <span class="text-sm">{{ machine.supplier ?? '---' }}</span>
    </div>
</template>

<script setup lang="ts">
import type { MachineDetails } from '../types/MachineDetails';

defineProps<{
    machine: MachineDetails
}>()
</script>

<style scoped></style>