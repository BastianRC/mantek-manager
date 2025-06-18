<template>
    <LoadingScreen :visible="isFetching && isFetchingRoles" />

    <HeaderComponent title="Perfil de Usuario" subtitle="Información y edición de usuario">
        <template v-slot:backButton>
            <Button variant="outline" size="icon" @click="$router.back">
                <ArrowLeft class="size-4" />
            </Button>
        </template>

        <template v-slot:buttons>
            <div v-if="editMode" class="flex items-center gap-2">
                <Button variant="outline" @click="handleCancel">
                    <X class="mr-0 h-4 w-4" />
                    <span class="hidden md:block">Cancelar</span>
                </Button>
                <Button @click="handleSubmit()">
                    <Save class="mr-0 h-4 w-4" />
                    <span class="hidden md:block">Guardar</span>
                </Button>
            </div>
            <Button v-else @click="setEditMode(true)">
                <Edit className="mr-2 h-4 w-4" />
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
                        <TabsTrigger value="work">Trabajo</TabsTrigger>
                        <TabsTrigger value="activity">Actividad</TabsTrigger>
                    </TabsList>
                    <TabsContent value="general" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle class="text-xl">Información Personal</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <UpdateUserPersonalInfoForm v-if="user" :user="user" :edit-mode="editMode"
                                    ref="generalFormRef" />
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="work" :unmount-on-hide="false" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle class="text-xl">Información Laboral</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <UpdateUserWokInfoForm v-if="user && roles" :user="user" :roles="roles" :edit-mode="editMode"
                                    ref="workFormRef" />
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="activity" :unmount-on-hide="false" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle class="text-xl">Actividad Reciente</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <AlertMessage variant="default" title="Información"
                                    message="Esta ventana aun no esta disponible. ¡Se añadira proximamente!"
                                    :icon="CircleAlert" />
                            </CardContent>
                        </Card>
                    </TabsContent>
                </Tabs>
            </div>

            <div class="space-y-6">
                <Card>
                    <CardContent>
                        <div class="flex flex-col items-center text-center space-y-4">
                            <!-- TODO: SE AÑADIRA CUANDO EL BACKEND LO PERMITA  -->
                            <UpdateUserAvatarForm v-if="user" :user="user" :edit-mode="false" ref="avatarFormRef" />
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle class="text-xl">Estadísticas</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <UserQuickStats v-if="user" :user="user" />
                    </CardContent>
                </Card>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ArrowLeft, CircleAlert, Edit, Save, X } from 'lucide-vue-next';
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue';
import Button from '~/components/ui/button/Button.vue';
import Card from '~/components/ui/card/Card.vue';
import CardContent from '~/components/ui/card/CardContent.vue';
import CardHeader from '~/components/ui/card/CardHeader.vue';
import CardTitle from '~/components/ui/card/CardTitle.vue';
import Tabs from '~/components/ui/tabs/Tabs.vue';
import TabsContent from '~/components/ui/tabs/TabsContent.vue';
import TabsList from '~/components/ui/tabs/TabsList.vue';
import TabsTrigger from '~/components/ui/tabs/TabsTrigger.vue';
import UpdateUserPersonalInfoForm from '../components/UpdateUserPersonalInfoForm.vue';
import { useGetUserById } from '../composables/useGetUserById';
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue';
import UpdateUserWokInfoForm from '../components/UpdateUserWokInfoForm.vue';
import AlertMessage from '~/components/custom/Alert/AlertMessage.vue';
import UpdateUserAvatarForm from '../components/UpdateUserAvatarForm.vue';
import UserQuickStats from '../components/UserQuickStats.vue';
import { useUpdateUser } from '../composables/useUpdateUser';
import { useGetRolesList } from '~/modules/role/composables/useGetRolesList';

const route = useRoute()
const { editMode, setEditMode, clearEditMode } = useEditMode()

const selectedId = ref<number | null>(Number(route.params.id))

const { data: user, isFetching, suspense } = useGetUserById(selectedId)
const { data: roles, isFetching: isFetchingRoles } = useGetRolesList()

const { mutate: update, isPending } = useUpdateUser()

const generalFormRef = ref()
const workFormRef = ref()
const avatarFormRef = ref()

const handleSubmit = async () => {
    const [general, work, avatar] = await Promise.all([
        generalFormRef.value?.submit(),
        workFormRef.value?.submit(),
        avatarFormRef.value?.submit(),
    ])

    if (!general || !work || !avatar) {
        return
    }

    const payload = {
        ...general,
        ...work,
        ...avatar
    }

    update({ id: selectedId.value!, payload }, {
        onSuccess: () => clearEditMode()
    })
}

const handleCancel = async () => {
    await Promise.all([
        generalFormRef.value?.resetForm(),
        workFormRef.value?.resetForm(),
        avatarFormRef.value?.resetForm()
    ])

    clearEditMode()
}


onServerPrefetch(async () => {
    await suspense()
})


</script>

<style scoped></style>