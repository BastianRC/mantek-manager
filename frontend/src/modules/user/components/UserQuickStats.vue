<template>
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <Clock class="h-4 w-4 text-muted-foreground" />
                <span class="text-sm">Órdenes asignadas</span>
            </div>
            <span class="font-medium">0</span>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <CheckCircle class="h-4 w-4 text-green-600" />
                <span class="text-sm">Completadas</span>
            </div>
            <span class="font-medium text-green-600">0</span>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <Calendar class="h-4 w-4 text-muted-foreground" />
                <span class="text-sm">Último acceso</span>
            </div>
            <span class="text-xs text-muted-foreground">{{ user.last_login }}</span>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Calendar, CheckCircle, Clock } from 'lucide-vue-next';
import type { UserDetails } from '../types/UserDetails';

defineProps<{
    user: UserDetails
}>()
</script>

<style scoped></style>