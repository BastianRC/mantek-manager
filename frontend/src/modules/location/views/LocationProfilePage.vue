<template>
    <LoadingScreen :visible="isFetching && isFetchingTypes && isFetchingSystems && isFetchingUsers" />

    <HeaderComponent title="Perfil de Ubicación" subtitle="Información y edición de la ubicación">
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
                        <TabsTrigger value="machines">Maquinas</TabsTrigger>
                        <TabsTrigger value="workOrders">Órdenes de Trabajo</TabsTrigger>
                    </TabsList>
                    <TabsContent value="general" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle class="text-xl">Información General</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <UpdateLocationGeneralInfoForm v-if="location && types" :location="location"
                                    :types="types" :edit-mode="editMode" ref="generalFormRef" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle class="text-xl">Información Adicional</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <UpdateLocationSecurityInfoForm v-if="location" :location="location"
                                    :edit-mode="editMode" ref="securityFormRef" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle class="text-xl">Sistemas</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <UpdateLocationSystemsForm v-if="location && systems" :location="location"
                                    :systems="systems" :edit-mode="editMode" ref="systemsFormRef" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle class="text-xl">Zonas</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <UpdateLocationZonesForm v-if="location" :location="location" :edit-mode="editMode"
                                    ref="zonesFormRef" />
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="machines" :unmount-on-hide="false" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle class="text-xl">Maquinas en esta Ubicación</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <ListMachinesOfLocation v-if="location" :location="location" />
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="workOrders" :unmount-on-hide="false" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle class="text-xl">Órdenes de Trabajo</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <ListWorkOrdersOfLocation v-if="location" :location="location" />
                            </CardContent>
                        </Card>
                    </TabsContent>
                </Tabs>
            </div>

            <div class="space-y-6">
                <Card>
                    <CardContent>
                        <UpdateLocationStateForm v-if="location" :location="location" :edit-mode="editMode"
                            ref="stateFormRef" />
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle class="text-xl">Estadísticas</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <LocationQuickStats v-if="location" :location="location" />
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle class="text-xl">Responsable</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <UpdateLocationManagerInfoForm v-if="location && users" :location="location" :users="users"
                            :edit-mode="editMode" ref="managerFormRef" />
                    </CardContent>
                </Card>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue'
import { useGetLocationById } from '../composables/useGetLocationById'
import { useGetLocationsList } from '../composables/useGetLocationsList'
import { useUpdateLocation } from '../composables/useUpdateLocation'
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue'
import Button from '~/components/ui/button/Button.vue'
import { ArrowLeft, Edit, Save, X } from 'lucide-vue-next'
import Tabs from '~/components/ui/tabs/Tabs.vue'
import TabsList from '~/components/ui/tabs/TabsList.vue'
import TabsTrigger from '~/components/ui/tabs/TabsTrigger.vue'
import TabsContent from '~/components/ui/tabs/TabsContent.vue'
import Card from '~/components/ui/card/Card.vue'
import CardHeader from '~/components/ui/card/CardHeader.vue'
import CardTitle from '~/components/ui/card/CardTitle.vue'
import CardContent from '~/components/ui/card/CardContent.vue'
import UpdateLocationGeneralInfoForm from '../components/UpdateLocationGeneralInfoForm.vue'
import { useGetLocationTypesList } from '../composables/useGetLocationTypesList'
import { useGetLocationSystemsList } from '../composables/useGetLocationSystemList'
import { useGetUsersList } from '~/modules/user/composables/useGetUsersList'
import UpdateLocationSystemsForm from '../components/UpdateLocationSystemsForm.vue'
import UpdateLocationZonesForm from '../components/UpdateLocationZonesForm.vue'
import UpdateLocationSecurityInfoForm from '../components/UpdateLocationSecurityInfoForm.vue'
import UpdateLocationManagerInfoForm from '../components/UpdateLocationManagerInfoForm.vue'
import ListMachinesOfLocation from '../components/ListMachinesOfLocation.vue'
import ListWorkOrdersOfLocation from '../components/ListWorkOrdersOfLocation.vue'
import UpdateLocationStateForm from '../components/UpdateLocationStateForm.vue'
import LocationQuickStats from '../components/LocationQuickStats.vue'

const route = useRoute()
const { editMode, setEditMode, clearEditMode } = useEditMode()

const selectedId = ref<number | null>(Number(route.params.id))

const { data: location, isFetching, suspense } = useGetLocationById(selectedId)
const { mutate: update, isPending } = useUpdateLocation()

const { data: types, isFetching: isFetchingTypes, suspense: suspenseTypes } = useGetLocationTypesList()
const { data: systems, isFetching: isFetchingSystems, suspense: suspenseSystems } = useGetLocationSystemsList()
const { data: users, isFetching: isFetchingUsers, suspense: suspenseUsers } = useGetUsersList()

const generalFormRef = ref()
const systemsFormRef = ref()
const zonesFormRef = ref()
const securityFormRef = ref()
const managerFormRef = ref()

const handleSubmit = async () => {
    const [general, systems, zones, security, manager] = await Promise.all([
        generalFormRef.value?.submit(),
        systemsFormRef.value?.submit(),
        zonesFormRef.value?.submit(),
        securityFormRef.value?.submit(),
        managerFormRef.value?.submit(),
    ])

    if (!general || !systems || !zones || !security || !manager) {
        return
    }

    const payload = {
        ...general,
        ...systems,
        ...zones,
        ...security,
        ...manager
    }

    update({ id: selectedId.value!, payload }, {
        onSuccess: () => clearEditMode()
    })
}

const handleCancel = async () => {
    await Promise.all([
        generalFormRef.value?.resetForm(),
        systemsFormRef.value?.resetForm(),
        zonesFormRef.value?.resetForm(),
        securityFormRef.value?.resetForm(),
        managerFormRef.value?.resetForm(),
    ])

    clearEditMode()
}

onServerPrefetch(async () => {
    await Promise.all([suspense, suspenseTypes, suspenseSystems, suspenseUsers])
})
</script>

<style scoped></style>