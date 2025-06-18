<template>
    <form class="space-y-6">
        <div class="space-y-2">
            <FormField v-slot="{ componentField }" name="title">
                <FormItem v-auto-animate>
                    <FormLabel>Titulo</FormLabel>
                    <FormControl v-if="editMode">
                        <Input type="text" placeholder="Reparación sistema eléctrico" v-bind="componentField" />
                    </FormControl>

                    <p v-else class="text-sm">{{ workOrder.title }}</p>
                    <FormMessage />
                </FormItem>
            </FormField>
        </div>

        <div class="space-y-2">
            <FormField v-slot="{ componentField }" name="description">
                <FormItem v-auto-animate>
                    <FormLabel>Descripción</FormLabel>
                    <FormControl v-if="editMode">
                        <Textarea placeholder="Describe detalladamente el trabajo a realizar..."
                            v-bind="componentField" />
                    </FormControl>

                    <p v-else class="text-sm">{{ workOrder.description }}</p>
                    <FormMessage />
                </FormItem>
            </FormField>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField v-slot="{ componentField, value }" name="status">
                    <FormItem v-auto-animate>
                        <FormLabel>Estado</FormLabel>
                        <div v-if="editMode && isStatusEditable" class="flex items-center gap-2">
                            <Select v-bind="componentField">
                                <FormControl>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Seleccionar estado">
                                            <component class="size-4" :is="getWorkOrderStatusMeta(value).icon">
                                            </component>
                                            {{ getWorkOrderStatusMeta(value).label }}
                                        </SelectValue>
                                    </SelectTrigger>
                                </FormControl>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem v-for="(status) in statuses" :disabled="status.disabled" :key="status.value"
                                            :value="status.value">
                                            <component class="size-4" :is="getWorkOrderStatusMeta(status.value).icon">
                                            </component>
                                            {{ getWorkOrderStatusMeta(status.value).label }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>

                        <p v-else class="text-sm flex items-center gap-2">
                            <component class="size-4" :is="getWorkOrderStatusMeta(workOrder.status).icon" />
                            {{ getWorkOrderStatusMeta(workOrder.status).label }}
                        </p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="priority">
                    <FormItem v-auto-animate>
                        <FormLabel>Prioridad</FormLabel>
                        <div v-if="editMode" class="flex items-center gap-2">
                            <Select v-bind="componentField">
                                <FormControl>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Seleccionar prioridad" />
                                    </SelectTrigger>
                                </FormControl>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem v-for="(priority) in priorities" :key="priority.value"
                                            :value="priority.value">
                                            <span>{{ priority.emoji }}</span>
                                            {{ priority.label }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>
                        <div v-else class="text-sm flex items-center gap-2">
                            <div class="relative flex items-center justify-start">
                                <span class="absolute animate-ping opacity-75">{{priorities.find((priority) =>
                                    priority.value ===
                                    workOrder.priority)?.emoji}}</span>
                                <span class="relative">{{priorities.find((priority) => priority.value ===
                                    workOrder.priority)?.emoji}}</span>
                            </div>
                            {{priorities.find((priority) => priority.value === workOrder.priority)?.label}}
                        </div>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="type">
                    <FormItem v-auto-animate>
                        <FormLabel>Tipo</FormLabel>
                        <div v-if="editMode" class="flex items-center gap-2">
                            <Select v-bind="componentField">
                                <FormControl>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Seleccionar tipo" />
                                    </SelectTrigger>
                                </FormControl>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem v-for="(type) in types" :key="type.value" :value="type.value">
                                            {{ type.label }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>

                        <p v-else class="text-sm">{{ getWorkOrderTypeMeta(workOrder.type).label }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="location_id">
                    <FormItem v-auto-animate>
                        <FormLabel>Ubicación</FormLabel>
                        <Combobox v-if="editMode" by="label" v-model="componentField.modelValue"
                            :disabled="!!values.machine_id">
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
                                    <ComboboxItem v-for="location in locations" :key="location.id" :value="location.id"
                                        @select="() => {
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

                        <p v-else class="text-sm">{{ workOrder.location.name }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>

        <div class="space-y-2">
            <FormField v-slot="{ componentField }" name="machine_id">
                <FormItem v-auto-animate>
                    <FormLabel>Máquina (Opcional)</FormLabel>
                    <div v-if="editMode" class="flex items-center gap-2">
                        <Combobox by="label" v-model:model-value="componentField.modelValue" class="w-full">
                            <FormControl>
                                <ComboboxAnchor>
                                    <div class="relative w-full items-center">
                                        <ComboboxInput
                                            :display-value="(val) => machines.find((m) => m.id === val)?.name ?? ''"
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
                                    <ComboboxItem v-for="machine in machines" :key="machine.id" :value="machine.id"
                                        @select="() => {
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
                        <Button type="button" variant="outline" @click="setFieldValue('machine_id', undefined)">
                            <Delete class="size-4" />
                        </Button>
                    </div>


                    <p v-else class="text-sm">{{ workOrder.machine?.name ?? '---' }}</p>
                    <FormMessage />
                </FormItem>
            </FormField>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField name="due_at">
                    <FormItem class="flex flex-col">
                        <FormLabel>Fecha de Vencimiento</FormLabel>
                        <Popover v-if="editMode">
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

                        <p v-else class="text-sm">{{ phDue }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ value, handleChange }" name="estimated_hours">
                    <FormItem v-auto-animate>
                        <FormLabel>Horas Estimadas</FormLabel>
                        <FormControl v-if="editMode">
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

                        <p v-else class="text-sm">{{ workOrder.estimated_hours }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>
    </form>
</template>

<script setup lang="ts">
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
import { getWorkOrderStatusMeta } from '../utils/getWorkOrderStatusMeta';
import Combobox from '~/components/ui/combobox/Combobox.vue';
import ComboboxAnchor from '~/components/ui/combobox/ComboboxAnchor.vue';
import ComboboxInput from '~/components/ui/combobox/ComboboxInput.vue';
import ComboboxTrigger from '~/components/ui/combobox/ComboboxTrigger.vue';
import { CalendarIcon, Check, ChevronsUpDown, Delete, Trash } from 'lucide-vue-next';
import ComboboxList from '~/components/ui/combobox/ComboboxList.vue';
import ComboboxEmpty from '~/components/ui/combobox/ComboboxEmpty.vue';
import ComboboxGroup from '~/components/ui/combobox/ComboboxGroup.vue';
import ComboboxItem from '~/components/ui/combobox/ComboboxItem.vue';
import ComboboxItemIndicator from '~/components/ui/combobox/ComboboxItemIndicator.vue';
import { CalendarDate, DateFormatter, parseDate } from '@internationalized/date'
import { toDate } from 'reka-ui/date'
import { cn } from '~/lib/utils';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import Popover from '~/components/ui/popover/Popover.vue';
import PopoverTrigger from '~/components/ui/popover/PopoverTrigger.vue';
import Button from '~/components/ui/button/Button.vue';
import PopoverContent from '~/components/ui/popover/PopoverContent.vue';
import Calendar from '~/components/ui/calendar/Calendar.vue';
import NumberField from '~/components/ui/number-field/NumberField.vue';
import NumberFieldContent from '~/components/ui/number-field/NumberFieldContent.vue';
import NumberFieldDecrement from '~/components/ui/number-field/NumberFieldDecrement.vue';
import NumberFieldInput from '~/components/ui/number-field/NumberFieldInput.vue';
import NumberFieldIncrement from '~/components/ui/number-field/NumberFieldIncrement.vue';
import type { WorkOrderDetails } from '../types/WorkOrderDetails';
import { getWorkOrderTypeMeta } from '../utils/getWorkOrderTypeMeta';

const props = withDefaults(defineProps<{
    workOrder: WorkOrderDetails
    locations: Location[]
    machines: Machine[]
    editMode: boolean
}>(), {
    editMode: false
})

const statusOptionsMap = {
  pending: [
    { label: 'Pendiente', value: 'pending', disabled: false },
    { label: 'Asignada', value: 'assigned', disabled: true },
    { label: 'Cancelada', value: 'canceled', disabled: false }
  ],
  assigned: [
    { label: 'Pendiente', value: 'pending', disabled: false },
    { label: 'En progreso', value: 'in_progress', disabled: true },
    { label: 'Cancelada', value: 'canceled', disabled: false }
  ],
  in_progress: [
    { label: 'En progreso', value: 'in_progress', disabled: true },
    { label: 'Cancelada', value: 'canceled', disabled: false }
  ],
  completed: [],
  canceled: []
}

const statuses = computed(() => {
  return statusOptionsMap[props.workOrder.status] || []
})

const isStatusEditable = computed(() => {
  const options = statusOptionsMap[props.workOrder.status] || []
  return options.some(option => !option.disabled)
})

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
    status: z
        .string()
        .nonempty({ message: 'El estado es obligatorio' }),
    priority: z
        .string()
        .nonempty({ message: 'La prioridad es obligatoria' }),
    type: z
        .string()
        .nonempty({ message: 'El tipo es obligatorio' }),
    location_id: z
        .number()
        .min(1, { message: 'La ubicación es obligatoria' }),
    machine_id: z
        .number()
        .optional(),
    due_at: z
        .string()
        .nonempty({ message: 'La fecha de vencimiento es obligatorio' }),
    estimated_hours: z
        .number()
        .min(0.1, { message: 'Las horas estimadas son obligatorias' }),
}))

const { handleSubmit, setFieldValue, values, resetForm } = useForm({
    validationSchema: formSchema,
    initialValues: {
        title: props.workOrder.title,
        description: props.workOrder.description,
        type: props.workOrder.type,
        priority: props.workOrder.priority,
        location_id: props.workOrder.location.id,
        machine_id: props.workOrder.machine?.id,
        status: props.workOrder.status,
        due_at: props.workOrder.due_at?.slice(0, 10) ?? '',
        estimated_hours: props.workOrder.estimated_hours,
    }
})

watch(dueDate, (val) => {
    phDue.value = val ?? null
}, { immediate: true })

const submit = handleSubmit(
    async (values) => {
        return values
    },
    () => {
        return undefined
    }
)

defineExpose({
    submit,
    resetForm,
    setFieldValue,
    values
})

</script>

<style scoped></style>