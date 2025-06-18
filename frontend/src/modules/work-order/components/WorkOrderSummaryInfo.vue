<template>
    <div class="space-y-4">
        <div class="text-center">
            <h3 class="font-semibold text-lg">{{ workOrder.order_number }}</h3>
            <p class="text-muted-foreground">{{ workOrder.title }}</p>
        </div>
        <div class="flex justify-center gap-2">
            <Badge :class="getWorkOrderStatusMeta(workOrder.status).color">
                {{ getWorkOrderStatusMeta(workOrder.status).label }}
            </Badge>
            <Badge :class="getWorkOrderPriorityMeta(workOrder.priority).color">
                {{ getWorkOrderPriorityMeta(workOrder.priority).label }}
            </Badge>
        </div>

        <div class="grid grid-cols-3 gap-5 mt-10">
            <Button class="bg-blue-600" @click="play(workOrder.id)" :disabled="!actionsMeta.canStartOrResume">
                <div class="relative flex items-center justify-start">
                    <PlayCircle class="absolute opacity-75 size-6"
                        :class="{ 'animate-ping': !actionsMeta.canStartOrResume && workOrder.status === 'in_progress', 'hidden': actionsMeta.canStartOrResume && workOrder.status !== 'in_progress' }" />
                    <PlayCircle class="relative size-6" />
                </div>
                <span class="hidden 2xl:block">Iniciar</span>
            </Button>

            <Button class="bg-yellow-600" @click="pause(workOrder.id)" :disabled="!actionsMeta.canPause">
                <PauseCircle class="size-6" />
                <span class="hidden 2xl:block">Pausar</span>
            </Button>

            <Button class="bg-green-600" @click="complete(workOrder.id)" :disabled="!actionsMeta.canComplete">
                <StopCircle class="size-6" />
                <span class="hidden 2xl:block">Completar</span>
            </Button>
        </div>
    </div>
</template>

<script setup lang="ts">
import Badge from '~/components/ui/badge/Badge.vue';
import type { WorkOrderDetails } from '../types/WorkOrderDetails';
import { getWorkOrderPriorityMeta } from '../utils/getWorkOrderPriorityMeta';
import { getWorkOrderStatusMeta } from '../utils/getWorkOrderStatusMeta';
import Button from '~/components/ui/button/Button.vue';
import { PauseCircle, PlayCircle, StopCircle } from 'lucide-vue-next';
import { usePlayWorkOrder } from '../composables/usePlayWorkOrder';
import { usePauseWorkOrder } from '../composables/usePauseWorkOrder';
import { getWorkOrderActionMeta } from '../utils/getWorkOrderActionMeta';
import { useCompleteWorkOrder } from '../composables/useCompleteWorkOrder';


const props = defineProps<{
    workOrder: WorkOrderDetails
}>()

const { mutate: play } = usePlayWorkOrder()
const { mutate: pause } = usePauseWorkOrder()
const { mutate: complete } = useCompleteWorkOrder()

const actionsMeta = computed(() => getWorkOrderActionMeta(props.workOrder))
</script>

<style scoped></style>