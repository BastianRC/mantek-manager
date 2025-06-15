<template>
    <form @submit="onSubmit" class="space-y-6">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Wrench class="h-5 w-5" />
                            Información Principal
                        </CardTitle>
                        <CardDescription>Datos básicos de la orden de trabajo</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="title">
                                <FormItem v-auto-animate>
                                    <FormLabel>Titulo *</FormLabel>
                                    <FormControl>
                                        <Input type="text" placeholder="Reparación sistema eléctrico"
                                            v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="description">
                                <FormItem v-auto-animate>
                                    <FormLabel>Descripción *</FormLabel>
                                    <FormControl>
                                        <Textarea placeholder="Describe detalladamente el trabajo a realizar..."
                                            v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <FormField v-slot="{ componentField }" name="type">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Tipo *</FormLabel>
                                        <div class="flex items-center gap-2">
                                            <Select v-bind="componentField">
                                                <FormControl>
                                                    <SelectTrigger>
                                                        <SelectValue placeholder="Seleccionar tipo" />
                                                    </SelectTrigger>
                                                </FormControl>
                                                <SelectContent>
                                                    <SelectGroup>
                                                        <SelectItem v-for="(type) in types" :key="type.value"
                                                            :value="type.value">
                                                            {{ type.label }}
                                                        </SelectItem>
                                                    </SelectGroup>
                                                </SelectContent>
                                            </Select>
                                        </div>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>

                            <div class="space-y-2">
                                <FormField v-slot="{ componentField }" name="priority">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Prioridad *</FormLabel>
                                        <div class="flex items-center gap-2">
                                            <Select v-bind="componentField">
                                                <FormControl>
                                                    <SelectTrigger>
                                                        <SelectValue placeholder="Seleccionar prioridad" />
                                                    </SelectTrigger>
                                                </FormControl>
                                                <SelectContent>
                                                    <SelectGroup>
                                                        <SelectItem v-for="(priority) in priorities"
                                                            :key="priority.value" :value="priority.value">
                                                            <span>{{ priority.emoji }}</span>
                                                            {{ priority.label }}
                                                        </SelectItem>
                                                    </SelectGroup>
                                                </SelectContent>
                                            </Select>
                                        </div>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="location_id">
                                <FormItem v-auto-animate>
                                    <FormLabel>Ubicación *
                                        <TooltipComponent v-if="locations.length === 0"
                                            message="No hay ubicaciones creadas" />
                                    </FormLabel>
                                    <Combobox by="label" v-model="componentField.modelValue" :disabled="!!values.machine_id">
                                        <FormControl>
                                            <ComboboxAnchor>
                                                <div class="relative w-full items-center">
                                                    <ComboboxInput
                                                        :display-value="(val) => locations.find((l) => l.id === val)?.name ?? ''"
                                                        placeholder="Seleccionar ubicación" />
                                                    <ComboboxTrigger
                                                        class="absolute end-0 inset-y-0 flex items-center justify-center">
                                                        <ChevronsUpDown class="size-4 text-muted-foreground" />
                                                    </ComboboxTrigger>
                                                </div>
                                            </ComboboxAnchor>
                                        </FormControl>

                                        <ComboboxList>
                                            <ComboboxEmpty>
                                                Sin resultados.
                                            </ComboboxEmpty>

                                            <ComboboxGroup>
                                                <ComboboxItem v-for="location in locations" :key="location.id"
                                                    :value="location.id" @select="() => {
                                                        setFieldValue('location_id', location.id)
                                                    }">
                                                    {{ location.name }}

                                                    <ComboboxItemIndicator>
                                                        <Check :class="cn('ml-auto h-4 w-4')" />
                                                    </ComboboxItemIndicator>
                                                </ComboboxItem>
                                            </ComboboxGroup>
                                        </ComboboxList>
                                    </Combobox>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="machine_id">
                                <FormItem v-auto-animate>
                                    <FormLabel>
                                        Máquina
                                        <TooltipComponent v-if="machines.length === 0"
                                            message="No hay máquinas creadas" />
                                    </FormLabel>
                                    <Combobox by="label">
                                        <FormControl>
                                            <ComboboxAnchor>
                                                <div class="relative w-full items-center">
                                                    <ComboboxInput :display-value="(val) => machines.find((m) => m.id === val)?.name ?? ''"
                                                        placeholder="Seleccionar máquina" />
                                                    <ComboboxTrigger
                                                        class="absolute end-0 inset-y-0 flex items-center justify-center">
                                                        <ChevronsUpDown class="size-4 text-muted-foreground" />
                                                    </ComboboxTrigger>
                                                </div>
                                            </ComboboxAnchor>
                                        </FormControl>

                                        <ComboboxList>
                                            <ComboboxEmpty>
                                                Sin resultados.
                                            </ComboboxEmpty>

                                            <ComboboxGroup>
                                                <ComboboxItem v-for="machine in machines" :key="machine.id"
                                                    :value="machine.id" @select="() => {
                                                        setFieldValue('machine_id', machine.id)
                                                        setFieldValue('location_id', machine.location.id)
                                                    }">
                                                    {{ machine.name }}

                                                    <ComboboxItemIndicator>
                                                        <Check :class="cn('ml-auto h-4 w-4')" />
                                                    </ComboboxItemIndicator>
                                                </ComboboxItem>
                                            </ComboboxGroup>
                                        </ComboboxList>
                                    </Combobox>

                                    <div v-if="values.machine_id" class="p-2 bg-muted rounded-lg text-sm">
                                        <strong>{{machines.find((machine) => machine.id === values.machine_id)?.name
                                        }}</strong> - {{machines.find((machine) => machine.id ===
                                                values.machine_id)?.location.name}}
                                    </div>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Materiales Necesarios</CardTitle>
                        <CardDescription>Lista de materiales requeridas</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="flex gap-2">
                            <Input type="text" placeholder="Nombre del material" v-model="newMaterial.material_name"
                                @keypress.enter.prevent="handleAddMaterial" class="flex-1" />
                            <NumberField :default-value="1" :min="1" locale="es" :model-value="newMaterial.quantity"
                                @update:model-value="newMaterial.quantity = $event" class="w-24">
                                <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                </NumberFieldContent>
                            </NumberField>

                            <Select v-model="newMaterial.unit">
                                <SelectTrigger>
                                    <SelectValue placeholder="Unidad" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem value="unit">Unidad</SelectItem>
                                        <SelectItem value="meter">Metro</SelectItem>
                                        <SelectItem value="liter">Litro</SelectItem>
                                        <SelectItem value="kg">Kg</SelectItem>
                                        <SelectItem value="box">Caja</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>

                            <Button type="button" @click="handleAddMaterial">
                                <Plus class="size-4" />
                            </Button>
                        </div>

                        <div class="space-y-2">
                            <div v-for="(material, index) in values.materials" :key="index"
                                class="flex items-center justify-between p-2 bg-muted rounded-lg">
                                <span class="text-sm">
                                    {{ material.material_name }} - {{ material.quantity }} {{ getUnitText(material.unit)
                                    }}
                                </span>
                                <Button type="button" variant="ghost" size="sm"
                                    @click="setFieldValue('materials', (values.materials ?? []).filter(m => m.material_name !== material.material_name))">
                                    <X class="size-4" />
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <div class="space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Info class="size-5" />
                            Información Adicional
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <FormField v-slot="{ componentField, value }" name="status">
                                <FormItem v-auto-animate>
                                    <FormLabel>Estado *</FormLabel>
                                    <div class="flex items-center gap-2">
                                        <Select v-bind="componentField">
                                            <FormControl>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Seleccionar técnico">
                                                        <component :is="getWorkOrderStatusMeta(value).icon">
                                                        </component>
                                                        {{ getWorkOrderStatusMeta(value).label }}
                                                    </SelectValue>
                                                </SelectTrigger>
                                            </FormControl>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectItem v-for="(status) in statuses" :key="status.value"
                                                        :value="status.value">
                                                        <component :is="getWorkOrderStatusMeta(status.value).icon">
                                                        </component>
                                                        {{ getWorkOrderStatusMeta(status.value).label }}
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>
                        <div class="space-y-2">
                            <FormField name="due_at">
                                <FormItem class="flex flex-col">
                                    <FormLabel>Fecha de Vencimiento *</FormLabel>
                                    <Popover>
                                        <PopoverTrigger as-child>
                                            <FormControl>
                                                <Button variant="outline" :class="cn(
                                                    'w-full ps-3 text-start font-normal',
                                                    !dueDate && 'text-muted-foreground',
                                                )">
                                                    <span>{{ dueDate ? new DateFormatter('es-ES', {
                                                        dateStyle: 'short'
                                                    }).format(toDate(dueDate)) : "Introduce una fecha" }}</span>
                                                    <CalendarIcon class="ms-auto size-4 opacity-50" />
                                                </Button>
                                                <input hidden>
                                            </FormControl>
                                        </PopoverTrigger>
                                        <PopoverContent class="w-auto p-0">
                                            <Calendar v-model:placeholder="phDue" :model-value="dueDate"
                                                calendar-label="Fecha de Instalación" initial-focus
                                                :min-value="new CalendarDate(1900, 1, 1)" @update:model-value="(v) => {
                                                    if (v) {
                                                        setFieldValue('due_at', v.toString())
                                                    }
                                                    else {
                                                        setFieldValue('due_at', undefined)
                                                    }
                                                }" />
                                        </PopoverContent>
                                    </Popover>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ value, handleChange }" name="estimated_hours">
                                <FormItem v-auto-animate>
                                    <FormLabel>Horas Estimadas *</FormLabel>
                                    <FormControl>
                                        <NumberField locale="es" :min="0" :step="0.1"
                                            :format-options="{ style: 'unit', unit: 'hour', unitDisplay: 'long' }"
                                            :model-value="value" @update:model-value="handleChange">
                                            <NumberFieldContent>
                                                <NumberFieldDecrement />
                                                <NumberFieldInput />
                                                <NumberFieldIncrement />
                                            </NumberFieldContent>
                                        </NumberField>
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div v-if="values.priority" class="p-3 rounded-lg border">
                            <div class="flex items-center gap-2 mb-2">
                                <AlertTriangle class="size-4" />
                                <span class="font-medium">Prioridad</span>
                            </div>
                            <Badge :class="getWorkOrderPriorityMeta(values.priority).color">
                                {{ getWorkOrderPriorityMeta(values.priority).emoji }} {{
                                    getWorkOrderPriorityMeta(values.priority).label }}
                            </Badge>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <UserIcon class="size-5" />
                            Asignación
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="assignee_id">
                                <FormItem v-auto-animate>
                                    <FormLabel>Técnico Asignado *</FormLabel>
                                    <div class="flex items-center gap-2">
                                        <Select v-bind="componentField">
                                            <FormControl>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Seleccionar técnico" />
                                                </SelectTrigger>
                                            </FormControl>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectItem v-for="(user) in users.filter(val => val.is_active)"
                                                        :key="user.id" :value="user.id">
                                                        {{ `${user.first_name} ${user.last_name}` }}
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="requested_by">
                                <FormItem v-auto-animate>
                                    <FormLabel>Solicitado por</FormLabel>
                                    <FormControl>
                                        <Input type="text" placeholder="Nombre del solicitante"
                                            v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>

        <Card>
            <CardHeader>
                <CardTitle className="flex items-center gap-2">
                    <FileText className="size-5" />
                    Notas Adicionales
                </CardTitle>
            </CardHeader>
            <CardContent>
                <div class="space-y-2">
                    <FormField v-slot="{ componentField }" name="notes">
                        <FormItem v-auto-animate>
                            <FormControl>
                                <Textarea
                                    placeholder="Información adicional, observaciones especiales, precauciones de seguridad...."
                                    v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                </div>
            </CardContent>
        </Card>

        <div class="flex items-center justify-end gap-4">
            <Button type="button" variant="outline" @click="$router.back">
                Cancelar
            </Button>
            <Button type="submit" class="min-w-32">
                <Save v-if="!loading" class="mr-2 size-4" />
                <Loader2 v-else class="mr-2 size-4 animate-spin" />
                Crear Orden de Trabajo
            </Button>
        </div>
    </form>
</template>

<script setup lang="ts">
import { AlertTriangle, CalendarIcon, Check, ChevronsUpDown, FileText, Info, Loader2, Plus, Save, UserIcon, Wrench, X } from 'lucide-vue-next';
import Card from '~/components/ui/card/Card.vue';
import CardContent from '~/components/ui/card/CardContent.vue';
import CardDescription from '~/components/ui/card/CardDescription.vue';
import CardHeader from '~/components/ui/card/CardHeader.vue';
import CardTitle from '~/components/ui/card/CardTitle.vue';
import { FormField } from '~/components/ui/form';
import FormControl from '~/components/ui/form/FormControl.vue';
import FormItem from '~/components/ui/form/FormItem.vue';
import FormLabel from '~/components/ui/form/FormLabel.vue';
import FormMessage from '~/components/ui/form/FormMessage.vue';
import Input from '~/components/ui/input/Input.vue';
import Select from '~/components/ui/select/Select.vue';
import SelectContent from '~/components/ui/select/SelectContent.vue';
import SelectGroup from '~/components/ui/select/SelectGroup.vue';
import SelectItem from '~/components/ui/select/SelectItem.vue';
import SelectTrigger from '~/components/ui/select/SelectTrigger.vue';
import SelectValue from '~/components/ui/select/SelectValue.vue';
import Textarea from '~/components/ui/textarea/Textarea.vue';
import type { Location } from '~/modules/location/types/Location';
import type { Machine } from '~/modules/machine/types/Machine';
import type { User } from '~/modules/user/types/User';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import Combobox from '~/components/ui/combobox/Combobox.vue';
import ComboboxAnchor from '~/components/ui/combobox/ComboboxAnchor.vue';
import ComboboxInput from '~/components/ui/combobox/ComboboxInput.vue';
import ComboboxTrigger from '~/components/ui/combobox/ComboboxTrigger.vue';
import ComboboxList from '~/components/ui/combobox/ComboboxList.vue';
import ComboboxEmpty from '~/components/ui/combobox/ComboboxEmpty.vue';
import ComboboxGroup from '~/components/ui/combobox/ComboboxGroup.vue';
import ComboboxItem from '~/components/ui/combobox/ComboboxItem.vue';
import ComboboxItemIndicator from '~/components/ui/combobox/ComboboxItemIndicator.vue';
import { cn, getInitials } from '~/lib/utils';
import TooltipComponent from '~/components/custom/Tooltip/TooltipComponent.vue';
import NumberField from '~/components/ui/number-field/NumberField.vue';
import NumberFieldContent from '~/components/ui/number-field/NumberFieldContent.vue';
import NumberFieldDecrement from '~/components/ui/number-field/NumberFieldDecrement.vue';
import NumberFieldInput from '~/components/ui/number-field/NumberFieldInput.vue';
import NumberFieldIncrement from '~/components/ui/number-field/NumberFieldIncrement.vue';
import type { CreateWorkOrderMaterialPayload } from '../types/CreateWorkOrderMaterialPayload';
import Button from '~/components/ui/button/Button.vue';
import Popover from '~/components/ui/popover/Popover.vue';
import PopoverTrigger from '~/components/ui/popover/PopoverTrigger.vue';
import PopoverContent from '~/components/ui/popover/PopoverContent.vue';
import { CalendarDate, DateFormatter, parseDate } from '@internationalized/date'
import { toDate } from 'reka-ui/date'
import Calendar from '~/components/ui/calendar/Calendar.vue';
import { getWorkOrderPriorityMeta } from '../utils/getWorkOrderPriorityMeta';
import Badge from '~/components/ui/badge/Badge.vue';
import type { WorkOrder } from '../types/WorkOrder';
import { getWorkOrderStatusMeta } from '../utils/getWorkOrderStatusMeta';

const props = defineProps<{
    loading?: boolean
    locations: Location[]
    machines: Machine[]
    users: User[],
    workOrders: WorkOrder[]
}>()

const emit = defineEmits(['submit'])

const newMaterial: Ref<CreateWorkOrderMaterialPayload> = ref({
    material_name: '',
    quantity: 1,
    unit: 'unit'
})

const handleAddMaterial = () => {
    const { material_name, quantity, unit } = newMaterial.value
    const name = material_name.trim()
    const materials = values.materials ?? []

    if (
        name &&
        quantity > 0 &&
        unit &&
        !materials.some(m =>
            m.material_name.toLowerCase() === name.toLowerCase() && m.unit === unit
        )
    ) {
        setFieldValue('materials', [...materials, { material_name: name, quantity, unit }])
        newMaterial.value = { material_name: '', quantity: 1, unit: 'unit' }
    }
}

const getUnitText = (unit: string): string => {
    switch (unit) {
        case 'unit':
            return '(Unidad)'
        case 'kg':
            return '(Kg)'
        case 'meter':
            return '(Metro)'
        case 'liter':
            return '(Litro)'
        case 'box':
            return '(Caja)'
        default:
            return unit
    }
}

const statuses: Ref<{ label: string; value: string }[]> = ref([
    { label: 'Pendiente', value: 'pending' },
    { label: 'En progreso', value: 'in_progress' },
    { label: 'Completada', value: 'completed' },
    { label: 'Cancelada', value: 'cancelled' }
])


const types: Ref<{ label: string, value: string }[]> = ref([
    { label: 'Correctiva', value: 'corrective' },
    { label: 'Preventiva', value: 'preventive' },
    { label: 'Predictiva', value: 'predictive' },
    { label: 'Inspección', value: 'inspection' },
    { label: 'Mejora', value: 'improvement' },
    { label: 'Legal / Normativa', value: 'legal' },
    { label: 'Instalación', value: 'installation' },
    { label: 'Limpieza técnica', value: 'cleaning' }
])

const priorities: Ref<{ label: string, value: string, emoji: string }[]> = ref([
    { label: 'Baja', value: 'low', emoji: "🟢" },
    { label: 'Media', value: 'medium', emoji: "🟡" },
    { label: 'Alta', value: 'high', emoji: "🟠" },
    { label: 'Critica', value: 'critical', emoji: "🔴" },
])

const dueDate = computed({
    get: () => values.due_at ? parseDate(values.due_at) : undefined,
    set: val => val,
})
const phDue = ref()

const formSchema = toTypedSchema(z.object({
    title: z
        .string()
        .nonempty({ message: 'El nombre es obligatorio' }),
    description: z
        .string()
        .nonempty({ message: 'La descripción es obligatoria' }),
    type: z
        .string()
        .nonempty({ message: 'El tipo es obligatorio' }),
    priority: z
        .string()
        .nonempty({ message: 'La prioridad es obligatoria' }),
    location_id: z
        .number()
        .min(1, { message: 'La ubicación es obligatoria' }),
    machine_id: z
        .number()
        .optional(),
    materials: z.array(
        z.object({
            material_name: z.string(),
            quantity: z.coerce.number(),
            unit: z.string()
        })
    ),
    status: z
        .string()
        .nonempty({ message: 'El estado es obligatorio' }),
    due_at: z
        .string()
        .nonempty({ message: 'La fecha de vencimiento es obligatorio' })
        .default('pending'),
    estimated_hours: z
        .number()
        .min(0.1, { message: 'Las horas estimadas son obligatorias' }),
    assignee_id: z
        .number()
        .min(1, { message: 'El tecnico asignado es obligatorio' }),
    requested_by: z
        .string()
        .optional()
}))

const { handleSubmit, setFieldValue, values } = useForm({
    validationSchema: formSchema,
    initialValues: {
        title: '',
        description: '',
        type: '',
        priority: '',
        materials: [],
        due_at: '',
        status: 'pending',
        estimated_hours: 1,
        requested_by: ''
    }
})

const onSubmit = handleSubmit((values) => {
    emit('submit', values)
})
</script>

<style scoped></style>