<template>
    <LoadingScreen :visible="isFetching" />
    <HeaderComponent title="Nuevo Usuario" subtitle="Crear una nueva cuenta de usuario">
        <template v-slot:backButton>
            <Button variant="outline" size="icon" @click="navigateTo('/dashboard/users')">
                <ArrowLeft className="size-4" />
            </Button>
        </template>
    </HeaderComponent>

    <div class="container mx-auto p-6">
        <CreateUserForm @submit="onCreate" v-if="roles" :roles="roles" />
    </div>
</template>

<script setup lang="ts">
import { ArrowLeft } from 'lucide-vue-next';
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue';
import Button from '~/components/ui/button/Button.vue';
import CreateUserForm from '../../components/CreateUserForm.vue';
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue';
import { useGetRolesList } from '~/modules/role/composables/useGetRolesList';
import { useCreateUser } from '../../composables/useCreateUser';
import type { CreateUserPayload } from '../../types/CreateUserPayload';

const {data: roles, isFetching, suspense } = useGetRolesList()

const { mutate: create } = useCreateUser()

const onCreate = (event: CreateUserPayload) => {
    create(event, {
        onSuccess: () => {
            navigateTo('/dashboard/users')
        }
    })
    
}

onServerPrefetch(async () => {
    await suspense()
})
</script>

<style scoped></style>