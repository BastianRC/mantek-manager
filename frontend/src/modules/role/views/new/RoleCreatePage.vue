<template>
    <HeaderComponent title="Nuevo Rol" subtitle="Crear un nuevo rol con permisos específicos">
        <template v-slot:backButton>
            <Button variant="outline" size="icon" @click="navigateTo('/dashboard/roles')">
                <ArrowLeft class="size-4" />
            </Button>
        </template>
    </HeaderComponent>

    <div class="container mx-auto p-6">
        <CreateRoleForm @submit="onCreate" :loading="isPending" />
    </div>
</template>

<script setup lang="ts">
import { ArrowLeft } from 'lucide-vue-next';
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue';
import Button from '~/components/ui/button/Button.vue';
import CreateRoleForm from '../../components/CreateRoleForm.vue';
import type { CreateRolePayload } from '../../types/CreateRolePayload';
import { useCreateRole } from '../../composables/useCreateRole';

const { mutate: create, isPending } = useCreateRole()

const onCreate = (event: CreateRolePayload) => {
    create(event, {
        onSuccess: () => {
            navigateTo('/dashboard/roles')
        }
    })

}

</script>

<style scoped></style>