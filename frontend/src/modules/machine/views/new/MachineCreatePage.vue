<template>
    <LoadingScreen :visible="isFetchingTypes && isFetchingCategories && isFetchingLocations && isFetchingMachines" />

    <HeaderComponent title="Nueva Máquina" subtitle="Registrar una nueva máquina">
        <template v-slot:backButton>
            <Button variant="outline" size="icon" @click="navigateTo('/dashboard/machines')">
                <ArrowLeft class="size-4" />
            </Button>
        </template>
    </HeaderComponent>

    <div class="container mx-auto p-6">
            <CreateMachineForm @submit="onCreate" v-if="types && categories && locations && machines" :types="types"
                :categories="categories" :locations="locations" :machines="machines" :loading="isPending" />
    </div>
</template>

<script setup lang="ts">
import { useGetLocationsList } from '~/modules/location/composables/useGetLocationsList';
import { useGetMachineCategoriesList } from '../../composables/category/useGetMachineCategoriesList';
import { useGetMachineTypesList } from '../../composables/type/useGetMachineTypesList';
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue';
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue';
import Button from '~/components/ui/button/Button.vue';
import { ArrowLeft } from 'lucide-vue-next';
import { useCreateMachine } from '../../composables/useCreateMachine';
import type { CreateMachinePayload } from '../../types/CreateMachinePayload';
import CreateMachineForm from '../../components/CreateMachineForm.vue';
import { useGetMachinesList } from '../../composables/useGetMachinesList';

const { data: types, isFetching: isFetchingTypes, suspense: suspenseTypes } = useGetMachineTypesList()
const { data: categories, isFetching: isFetchingCategories, suspense: suspenseCategories } = useGetMachineCategoriesList()
const { data: locations, isFetching: isFetchingLocations, suspense: suspenseLocations } = useGetLocationsList()
const { data: machines, isFetching: isFetchingMachines, suspense: suspenseMachines } = useGetMachinesList()

const { mutate: create, isPending } = useCreateMachine()

const onCreate = ((event: CreateMachinePayload) => {
    create(event, {
        onSuccess: () => {
            navigateTo('/dashboard/machines')
        }
    })

})

onServerPrefetch(async () => {
    await Promise.all([
        suspenseTypes,
        suspenseCategories,
        suspenseLocations,
        suspenseMachines
    ])
})
</script>

<style scoped></style>