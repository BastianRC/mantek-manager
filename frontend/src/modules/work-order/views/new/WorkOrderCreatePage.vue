<template>
    <LoadingScreen :visible="isFetchingUsers && isFetchingLocations && isFetchingMachines && isFetchingWorkOrders" />

    <HeaderComponent title="Nueva Orden de Trabajo" subtitle="Crear una nueva orden de trabajo">
        <template v-slot:backButton>
            <Button variant="outline" size="icon" @click="navigateTo('/dashboard/work-orders')">
                <ArrowLeft class="size-4" />
            </Button>
        </template>
    </HeaderComponent>

    <div class="container mx-auto p-6">
        <CreateWorkOrderForm @submit="onCreate" v-if="users && locations && machines && workOrders" :locations="locations"
            :machines="machines" :users="users" :workOrders="workOrders" :loading="isPending" />
    </div>
</template>

<script setup lang="ts">
import { useGetLocationsList } from '~/modules/location/composables/useGetLocationsList'
import { useGetMachinesList } from '~/modules/machine/composables/useGetMachinesList'
import { useGetUsersList } from '~/modules/user/composables/useGetUsersList'
import { useCreateWorkOrder } from '../../composables/useCreateWorkOrder'
import type { CreateWorkOrderPayload } from '../../types/CreateWorkOrderPayload'
import CreateWorkOrderForm from '../../components/CreateWorkOrderForm.vue'
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue'
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue'
import Button from '~/components/ui/button/Button.vue'
import { ArrowLeft } from 'lucide-vue-next'
import { useGetWorkOrdersList } from '../../composables/useGetWorkOrdersList'

const { data: locations, isFetching: isFetchingLocations, suspense: suspenseLocations } = useGetLocationsList()
const { data: machines, isFetching: isFetchingMachines, suspense: suspenseMachines } = useGetMachinesList()
const { data: users, isFetching: isFetchingUsers, suspense: suspenseUsers } = useGetUsersList()
const { data: workOrders, isFetching: isFetchingWorkOrders, suspense: suspenseWorkOrders } = useGetWorkOrdersList()

const { mutate: create, isPending } = useCreateWorkOrder()

const onCreate = ((event: CreateWorkOrderPayload) => {
    create(event, {
        onSuccess: () => {
            navigateTo('/dashboard/work-orders')
        }
    })

})

onServerPrefetch(async () => {
    await Promise.all([
        suspenseLocations,
        suspenseMachines,
        suspenseUsers,
        suspenseWorkOrders
    ])
})
</script>

<style scoped></style>