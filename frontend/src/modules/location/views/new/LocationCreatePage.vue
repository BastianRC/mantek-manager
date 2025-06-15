<template>
    <LoadingScreen :visible="isFetchingTypes && isFetchingSystems && isFetchingUsers" />

    <HeaderComponent title="Nueva Ubicación" subtitle="Registrar una nueva ubicación">
        <template v-slot:backButton>
            <Button variant="outline" size="icon" @click="navigateTo('/dashboard/locations')">
                <ArrowLeft class="size-4" />
            </Button>
        </template>
    </HeaderComponent>

    <div class="container mx-auto p-6">
        <CreateLocationForm @submit="onCreate" v-if="types && systems && users" :types="types" :systems="systems"
            :users="users" :loading="isPending" />
    </div>
</template>

<script setup lang="ts">
import { ArrowLeft, Router } from 'lucide-vue-next';
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue';
import Button from '~/components/ui/button/Button.vue';
import CreateLocationForm from '../../components/CreateLocationForm.vue';
import { useGetLocationTypesList } from '../../composables/useGetLocationTypesList';
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue';
import { useGetLocationSystemsList } from '../../composables/useGetLocationSystemList';
import { useGetUsersList } from '~/modules/user/composables/useGetUsersList';
import { useCreateLocation } from '../../composables/useCreateLocation';
import type { CreateLocationPayload } from '../../types/CreateLocationPayload';

const { data: types, isFetching: isFetchingTypes, suspense: suspenseTypes } = useGetLocationTypesList()
const { data: systems, isFetching: isFetchingSystems, suspense: suspenseSystems } = useGetLocationSystemsList()
const { data: users, isFetching: isFetchingUsers, suspense: suspenseUsers } = useGetUsersList()

const { mutate: create, isPending } = useCreateLocation()

const onCreate = ((event: CreateLocationPayload) => {
    create(event, {
        onSuccess: () => {
            navigateTo('/dashboard/locations')
        }
    })

})

onServerPrefetch(async () => {
    await Promise.all([suspenseTypes, suspenseSystems, suspenseUsers])
})
</script>

<style scoped></style>