<template>
    <LoadingScreen :visible="isFetching && isPending && isFetchingRoles" />

    <HeaderComponent title="Perfil de Rol" subtitle="Información y edición del rol y sus permisos">
        <template v-slot:backButton>
            <Button variant="outline" size="icon" @click="$router.back">
                <ArrowLeft class="size-4" />
            </Button>
        </template>

        <template v-slot:buttons>
            <div v-if="editMode" class="flex items-center gap-2">
                <Button variant="outline" @click="handleCancel">
                    <X class="mr-0 size-4" />
                    <span class="hidden md:block">Cancelar</span>
                </Button>
                <Button @click="handleSubmit">
                    <Save class="mr-0 size-4" />
                    <span class="hidden md:block">Guardar</span>
                </Button>
            </div>
            <Button v-else @click="setEditMode(true)">
                <Edit className="mr-2 size-4" />
                Editar
            </Button>
        </template>
    </HeaderComponent>

    <div class="container mx-auto p-6">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <Tabs default-value="general" :unmount-on-hide="false" class="space-y-6">
                    <TabsList>
                        <TabsTrigger value="general">General</TabsTrigger>
                        <TabsTrigger value="permissions">Permisos</TabsTrigger>
                        <TabsTrigger value="users">Usuarios</TabsTrigger>
                    </TabsList>
                    <TabsContent value="general" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle class="text-xl">Información General</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <UpdateRoleGeneralInfoForm v-if="role" :role="role" :edit-mode="editMode"
                                    ref="generalFormRef" />
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="permissions" :unmount-on-hide="false" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle class="text-xl">Permisos del Rol</CardTitle>
                                <CardDescription>Selecciona los permisos que tendrán los usuarios con este rol
                                </CardDescription>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <UpdateRolePermissionsForm v-if="role" :role="role" :edit-mode="editMode"
                                    ref="permissionsFormRef" />
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="users" :unmount-on-hide="false" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle class="text-xl">Usuarios Asignados</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <ListRoleAssignedToUsers v-if="role" :role="role" />
                            </CardContent>
                        </Card>
                    </TabsContent>
                </Tabs>
            </div>

            <div class="space-y-6">
                <Card>
                    <CardContent>
                        <div class="flex flex-col items-center text-center space-y-4">
                            <UpdateRoleStateForm v-if="role" :role="role" :edit-mode="editMode" ref="stateFormRef" />
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle class="text-xl">Estadísticas</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <RoleQuickStats v-if="role && roles" :role="role"
                            :total="new Set(roles.flatMap(role => role.permissions).map(p => p.id)).size" />
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle class="text-xl">Resumen de Permisos</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <SummaryRolePermissions v-if="role" :role="role" />
                    </CardContent>
                </Card>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ArrowLeft, Edit, Save, X } from 'lucide-vue-next';
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue';
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue';
import Button from '~/components/ui/button/Button.vue';
import { useGetRoleById } from '../composables/useGetRoleById';
import { useUpdateRole } from '../composables/useUpdateRole';
import Tabs from '~/components/ui/tabs/Tabs.vue';
import TabsList from '~/components/ui/tabs/TabsList.vue';
import TabsTrigger from '~/components/ui/tabs/TabsTrigger.vue';
import TabsContent from '~/components/ui/tabs/TabsContent.vue';
import Card from '~/components/ui/card/Card.vue';
import CardHeader from '~/components/ui/card/CardHeader.vue';
import CardTitle from '~/components/ui/card/CardTitle.vue';
import CardContent from '~/components/ui/card/CardContent.vue';
import UpdateRoleGeneralInfoForm from '../components/UpdateRoleGeneralInfoForm.vue';
import UpdateRolePermissionsForm from '../components/UpdateRolePermissionsForm.vue';
import CardDescription from '~/components/ui/card/CardDescription.vue';
import ListRoleAssignedToUsers from '../components/ListRoleAssignedToUsers.vue';
import UpdateRoleStateForm from '../components/UpdateRoleStateForm.vue';
import { useGetRolesList } from '../composables/useGetRolesList';
import RoleQuickStats from '../components/RoleQuickStats.vue';
import SummaryRolePermissions from '../components/SummaryRolePermissions.vue';

const route = useRoute()
const { editMode, setEditMode, clearEditMode } = useEditMode()

const selectedId = ref<number | null>(Number(route.params.id))

const { data: role, isFetching, suspense } = useGetRoleById(selectedId)
const { data: roles, isFetching: isFetchingRoles, suspense: suspenseRoles } = useGetRolesList()
const { mutate: update, isPending } = useUpdateRole()

const generalFormRef = ref()
const permissionsFormRef = ref()
const stateFormRef = ref()

const handleSubmit = async () => {
    const [general, permissions, state] = await Promise.all([
        generalFormRef.value?.submit(),
        permissionsFormRef.value?.submit(),
        stateFormRef.value?.submit()
    ])

    if (!general || !permissions || !stateFormRef) {
        return
    }

    const payload = {
        ...general,
        ...permissions,
        ...state
    }

    update({ id: selectedId.value!, payload }, {
        onSuccess: () => clearEditMode()
    })
}

const handleCancel = async () => {
    await Promise.all([
        generalFormRef.value?.resetForm(),
        permissionsFormRef.value?.resetForm(),
        stateFormRef.value?.resetForm()
    ])

    clearEditMode()
}


onServerPrefetch(async () => {
    await Promise.all([suspense, suspenseRoles])
})
</script>

<style scoped></style>