<template>
    <LoadingScreen
        :visible="isPending || (isFetching && isFetchingLocations && isFetchingMachines && isFetchingUsers && isFetchingChronologies)" />

    <HeaderComponent title="Detalles de la Orden de Trabajo" subtitle="Información completa y seguimiento de la orden">
        <template v-slot:backButton>
            <Button variant="outline" size="icon" @click="navigateTo('/dashboard/work-orders')">
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
                        <WorkOrderSummaryInfo v-if="workOrder" :work-order="workOrder" />
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Asignación</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <UpdateWorkOrderAssigneeUser ref="assigneeFormRef" v-if="workOrder && users"
                            :work-order="workOrder" :users="users" :edit-mode="editMode" />
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Información Adicional</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="flex items-center gap-2">
                            <Clock class="size-4 text-muted-foreground" />
                            <span class="text-sm">Estimado: {{ workOrder?.estimated_hours }}h</span>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <div class="lg:col-span-2 order-2 lg:order-1">
                <Tabs default-value="general" :unmount-on-hide="false" class="space-y-6">
                    <TabsList>
                        <TabsTrigger value="general">General</TabsTrigger>
                        <TabsTrigger value="chronology">Cronologia</TabsTrigger>
                    </TabsList>
                    <TabsContent value="general" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Información General</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <UpdateWorkOrderGeneralInfo ref="generalFormRef"
                                    v-if="workOrder && locations && machines" :work-order="workOrder"
                                    :locations="locations" :machines="machines" :edit-mode="editMode" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Materiales Usados</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <UpdateWorkOrderMaterials ref="materialsFormRef" v-if="workOrder"
                                    :work-order="workOrder" :edit-mode="editMode" />
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="chronology" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Cronologia</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <ChronologyList v-if="chronologies" :chronologies="chronologies" />
                            </CardContent>
                        </Card>

                    </TabsContent>
                </Tabs>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue'
import { useGetWorkOrderById } from '../composables/useGetWorkOrderById'
import { useUpdateWorkOrder } from '../composables/useUpdateWorkOrder'
import { useGetLocationsList } from '~/modules/location/composables/useGetLocationsList'
import { useGetMachinesList } from '~/modules/machine/composables/useGetMachinesList'
import Button from '~/components/ui/button/Button.vue'
import { ArrowLeft, Clock, Edit, Save, X } from 'lucide-vue-next'
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue'
import Card from '~/components/ui/card/Card.vue'
import CardContent from '~/components/ui/card/CardContent.vue'
import CardHeader from '~/components/ui/card/CardHeader.vue'
import CardTitle from '~/components/ui/card/CardTitle.vue'
import Tabs from '~/components/ui/tabs/Tabs.vue'
import TabsList from '~/components/ui/tabs/TabsList.vue'
import TabsTrigger from '~/components/ui/tabs/TabsTrigger.vue'
import TabsContent from '~/components/ui/tabs/TabsContent.vue'
import UpdateWorkOrderGeneralInfo from '../components/UpdateWorkOrderGeneralInfo.vue'
import UpdateWorkOrderMaterials from '../components/UpdateWorkOrderMaterials.vue'
import WorkOrderSummaryInfo from '../components/WorkOrderSummaryInfo.vue'
import UpdateWorkOrderAssigneeUser from '../components/UpdateWorkOrderAssigneeUser.vue'
import { useGetUsersList } from '~/modules/user/composables/useGetUsersList'
import ChronologyList from '~/modules/chronology/components/ChronologyList.vue'
import { useGetChronologyByTarget } from '~/modules/chronology/composables/useGetChronologyByTarget'

const route = useRoute()
const { editMode, setEditMode, clearEditMode } = useEditMode()

const selectedId = ref<number | null>(Number(route.params.id))

const { data: workOrder, isFetching, suspense } = useGetWorkOrderById(selectedId)
const { mutate: update, isPending } = useUpdateWorkOrder()

const { data: locations, isFetching: isFetchingLocations, suspense: suspenseLocations } = useGetLocationsList()
const { data: machines, isFetching: isFetchingMachines, suspense: suspenseMachines } = useGetMachinesList()
const { data: users, isFetching: isFetchingUsers, suspense: suspenseUsers } = useGetUsersList()

const { data: chronologies, isFetching: isFetchingChronologies, suspense: suspenseChronologies } = useGetChronologyByTarget(selectedId, toRef('work_order'))

const generalFormRef = ref()
const materialsFormRef = ref()
const assigneeFormRef = ref()

const handleSubmit = async () => {
    const [general, materials, assignee] = await Promise.all([
        generalFormRef.value?.submit(),
        materialsFormRef.value?.submit(),
        assigneeFormRef.value?.submit()
    ])

    if (!general || !materials) {
        return
    }

    const payload = {
        ...general,
        ...materials,
        ...assignee
    }

    console.log(payload)

    update({ id: selectedId.value!, payload }, {
        onSuccess: () => clearEditMode()
    })
}

const handleCancel = async () => {
    await Promise.all([
        generalFormRef.value?.resetForm(),
        materialsFormRef.value?.resetForm(),
        assigneeFormRef.value?.resetForm()
    ])

    clearEditMode()
}

onServerPrefetch(async () => {
    await Promise.all([
        suspense,
        suspenseLocations,
        suspenseMachines,
        suspenseUsers,
        suspenseChronologies
    ])
})
</script>

<style scoped></style>