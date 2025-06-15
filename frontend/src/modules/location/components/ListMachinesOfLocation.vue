<template>
    <div class="space-y-4">
        <div v-if="location.machines?.length !== 0" v-for="(machine) in location.machines" :key="machine.id"
            class="flex items-center justify-between p-4 border rounded-lg">
            <div class="flex items-center gap-3">
                <Cpu class="h-8 w-8 text-muted-foreground" />
                <div>
                    <p class="font-medium">{{ machine.name }}</p>
                    <p class="text-sm text-muted-foreground">
                        {{ machine.type }} • {{ machine.location }}
                    </p>
                </div>
            </div>

            <Badge :class="`${getStatusMeta(machine.status).color} border`">
                {{ getStatusMeta(machine.status).label }}
            </Badge>
        </div>

        <AlertMessage v-else title="Sin resultados" message="¡No se han encotrado maquinas en esta ubicación!"
            :icon="AlertCircle" variant="default" />
    </div>
</template>

<script setup lang="ts">
import { AlertCircle, Cpu } from 'lucide-vue-next';
import type { LocationDetails } from '../types/LocationDetails';
import Badge from '~/components/ui/badge/Badge.vue';
import AlertMessage from '~/components/custom/Alert/AlertMessage.vue';
import { getStatusMeta } from '~/modules/machine/utils/getStatusMeta';

const props = defineProps<{
    location: LocationDetails,
}>()

</script>

<style scoped></style>