<template>
    <LoadingScreen
        :visible="isFetching || (isFetchingTypes && isFetchingCategories && isFetchingLocations && isFetchingMachines)" />

    <HeaderComponent title="Perfil de la Máquina" subtitle="Información completa del equipo">
        <template v-slot:backButton>
            <Button variant="outline" size="icon" @click="navigateTo('/dashboard/machines')">
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
                <Edit class="mr-2 size-4" />
                Editar
            </Button>
        </template>
    </HeaderComponent>

    <div class="container mx-auto p-6">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 order-1 lg:order-2">
                <Card>
                    <CardContent class="p-6">
                        <UpdateMachineStatusForm ref="statusFormRef" v-if="machine" :machine="machine"
                            :edit-mode="editMode" />
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Información Rápida</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <MachineQuickInfo v-if="machine" :machine="machine" />
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Información Comercial</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <MachineComercialInfo v-if="machine" :machine="machine" />
                    </CardContent>
                </Card>
            </div>

            <div class="lg:col-span-2 order-2 lg:order-1">
                <Tabs default-value="general" :unmount-on-hide="false" class="space-y-6">
                    <TabsList>
                        <TabsTrigger value="general">General</TabsTrigger>
                        <TabsTrigger value="maintenance">Mantenimiento</TabsTrigger>
                    </TabsList>
                    <TabsContent value="general" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Información General</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <UpdateMachineGeneralInfoForm ref="generalFormRef"
                                    v-if="machine && types && categories && locations && machines" :machine="machine"
                                    :types="types" :categories="categories" :locations="locations" :machines="machines"
                                    :edit-mode="editMode" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Especificaciones Técnicas</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <UpdateMachineTechnicalInfoForm ref="technicalFormRef" v-if="machine" :machine="machine"
                                    :edit-mode="editMode" />
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="maintenance" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Historial de Mantenimiento</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <MachineMaintenanceHistory v-if="machine" :machine="machine" />
                            </CardContent>
                        </Card>
                    </TabsContent>
                </Tabs>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue'
import { useGetMachineById } from '../composables/useGetMachineById'
import { useUpdateMachine } from '../composables/useUpdateMachine'
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
import UpdateMachineGeneralInfoForm from '../components/UpdateMachineGeneralInfoForm.vue'
import { useGetMachineTypesList } from '../composables/type/useGetMachineTypesList'
import { useGetMachineCategoriesList } from '../composables/category/useGetMachineCategoriesList'
import { useGetLocationsList } from '~/modules/location/composables/useGetLocationsList'
import { useGetMachinesList } from '../composables/useGetMachinesList'
import UpdateMachineTechnicalInfoForm from '../components/UpdateMachineTechnicalInfoForm.vue'
import MachineMaintenanceHistory from '../components/MachineMaintenanceHistory.vue'
import UpdateMachineStatusForm from '../components/UpdateMachineStatusForm.vue'
import MachineQuickInfo from '../components/MachineQuickInfo.vue'
import MachineComercialInfo from '../components/MachineComercialInfo.vue'

const route = useRoute()
const { editMode, setEditMode, clearEditMode } = useEditMode()

const selectedId = ref<number | null>(Number(route.params.id))

const { data: machine, isFetching, suspense } = useGetMachineById(selectedId)
const { mutate: update, isPending } = useUpdateMachine()

const { data: types, isFetching: isFetchingTypes, suspense: suspenseTypes } = useGetMachineTypesList()
const { data: categories, isFetching: isFetchingCategories, suspense: suspenseCategories } = useGetMachineCategoriesList()
const { data: locations, isFetching: isFetchingLocations, suspense: suspenseLocations } = useGetLocationsList()
const { data: machines, isFetching: isFetchingMachines, suspense: suspenseMachines } = useGetMachinesList()

const generalFormRef = ref()
const technicalFormRef = ref()
const statusFormRef = ref()

const handleSubmit = async () => {
    const [general, technical, status] = await Promise.all([
        generalFormRef.value?.submit(),
        technicalFormRef.value?.submit(),
        statusFormRef.value?.submit()
    ])

    if (!general || !technical || !status) {
        return
    }

    const payload = {
        ...general,
        ...technical,
        ...status
    }

    console.log(payload)

    update({ id: selectedId.value!, payload }, {
        onSuccess: () => clearEditMode()
    })
}

const handleCancel = async () => {
    await Promise.all([
        generalFormRef.value?.resetForm(),
        technicalFormRef.value?.resetForm(),
        statusFormRef.value?.resetForm()
    ])

    clearEditMode()
}

onServerPrefetch(async () => {
    await Promise.all([
        suspense,
        suspenseTypes,
        suspenseCategories,
        suspenseLocations,
        suspenseMachines
    ])
})
</script>

<style scoped></style>