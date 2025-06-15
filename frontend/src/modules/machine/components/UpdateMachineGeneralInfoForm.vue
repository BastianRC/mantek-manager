<template>
    <form class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="name">
                    <FormItem v-auto-animate>
                        <FormLabel>Nombre</FormLabel>
                        <FormControl v-if="editMode">
                            <Input type="text" placeholder="Compresor Principal A" v-bind="componentField" />
                        </FormControl>

                        <p v-else class="text-sm">{{ machine.name }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="type_id">
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
                                        <SelectItem v-for="(type, index) in types" :key="index" :value="type.id">
                                            {{ type.name }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>

                            <CreateMachineTypeForm />
                        </div>

                        <p v-else class="text-sm">{{ machine.type.name }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField v-slot="{ componentField, value }" name="machine_model">
                    <FormItem v-auto-animate>
                        <FormLabel>Modelo</FormLabel>
                        <div v-if="editMode" class="flex items-center gap-2">
                            <FormControl v-if="isNewModel">
                                <Input type="text" placeholder="Introducir nuevo modelo" v-bind="componentField" />
                            </FormControl>

                            <Combobox v-else by="label" class="w-full">
                                <FormControl>
                                    <ComboboxAnchor>
                                        <div class="relative w-full items-center">
                                            <ComboboxInput :display-value="(val) => val?.label ?? value"
                                                placeholder="Seleccionar modelo" />
                                            <ComboboxTrigger
                                                class="absolute end-0 inset-y-0 flex items-center justify-center opacity-50">
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
                                        <ComboboxItem v-for="model in models" :key="model.value" :value="model" @select="() => {
                                            setFieldValue('machine_model', model.value)
                                        }">
                                            {{ model.label }}

                                            <ComboboxItemIndicator>
                                                <Check :class="cn('ml-auto size-4')" />
                                            </ComboboxItemIndicator>
                                        </ComboboxItem>
                                    </ComboboxGroup>
                                </ComboboxList>
                            </Combobox>

                            <Button type="button" variant="outline"
                                @click="isNewModel ? isNewModel = false : isNewModel = true; setFieldValue('machine_model', '')">
                                <TextCursorInput v-if="!isNewModel" />
                                <TextSearch v-else />
                            </Button>
                        </div>

                        <p v-else class="text-sm">{{ machine.machine_model }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="serial_number">
                    <FormItem v-auto-animate>
                        <FormLabel>Número de Serie</FormLabel>
                        <FormControl v-if="editMode">
                            <Input type="text" placeholder="AC2023001" v-bind="componentField" />
                        </FormControl>

                        <p v-else class="text-sm">{{ machine.serial_number }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField v-slot="{ componentField, value }" name="manufacturer">
                    <FormItem v-auto-animate>
                        <FormLabel>Fabricante</FormLabel>
                        <div v-if="editMode" class="flex items-center gap-2">
                            <FormControl v-if="isNewManufacturer">
                                <Input type="text" placeholder="Introducir nuevo fabricante" v-bind="componentField" />
                            </FormControl>

                            <Combobox v-else by="label" class="w-full">
                                <FormControl>
                                    <ComboboxAnchor>
                                        <div class="relative w-full items-center">
                                            <ComboboxInput :display-value="(val) => val ?? value"
                                                placeholder="Seleccionar fabricante" />
                                            <ComboboxTrigger
                                                class="absolute end-0 inset-y-0 flex items-center justify-center opacity-50">
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
                                        <ComboboxItem v-for="manufacturer in manufacturers" :key="manufacturer.value"
                                            :value="manufacturer.value" @select="() => {
                                                setFieldValue('manufacturer', manufacturer.value)
                                            }">
                                            {{ manufacturer.label }}

                                            <ComboboxItemIndicator>
                                                <Check :class="cn('ml-auto size-4')" />
                                            </ComboboxItemIndicator>
                                        </ComboboxItem>
                                    </ComboboxGroup>
                                </ComboboxList>
                            </Combobox>

                            <Button type="button" variant="outline"
                                @click="isNewManufacturer ? isNewManufacturer = false : isNewManufacturer = true; setFieldValue('manufacturer', '')">
                                <TextCursorInput v-if="!isNewManufacturer" />
                                <TextSearch v-else />
                            </Button>
                        </div>

                        <p v-else class="text-sm">{{ machine.manufacturer }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="category_id">
                    <FormItem v-auto-animate>
                        <FormLabel>Categoría</FormLabel>
                        <div v-if="editMode" class="flex items-center gap-2">
                            <Select v-bind="componentField">
                                <FormControl>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Seleccionar categoría" />
                                    </SelectTrigger>
                                </FormControl>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem v-for="(category) in categories" :key="category.id"
                                            :value="category.id">
                                            {{ category.name }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>

                            <CreateMachineCategoryForm />
                        </div>

                        <p v-else class="text-sm">{{ machine.category.name }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>

        <div class="space-y-2">
            <FormField v-slot="{ componentField }" name="location_id">
                <FormItem v-auto-animate>
                    <FormLabel>Ubicación</FormLabel>
                    <Select v-if="editMode" v-bind="componentField">
                        <FormControl>
                            <SelectTrigger>
                                <SelectValue placeholder="Seleccionar ubicación" />
                            </SelectTrigger>
                        </FormControl>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem v-for="(location) in locations" :key="location.id" :value="location.id">
                                    {{ location.name }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>

                    <p v-else class="text-sm">{{ machine.location.name ?? '---' }}</p>
                    <FormMessage />
                </FormItem>
            </FormField>
        </div>

        <div class="space-y-2">
            <FormField v-slot="{ componentField }" name="description">
                <FormItem v-auto-animate>
                    <FormLabel>Descripción</FormLabel>
                    <FormControl v-if="editMode">
                        <Textarea placeholder="Descripción detallada de la máquina..." v-bind="componentField" />
                    </FormControl>

                    <p v-else class="text-sm">{{ machine.description ?? '---' }}</p>
                    <FormMessage />
                </FormItem>
            </FormField>
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
import CreateMachineTypeForm from './CreateMachineTypeForm.vue';
import type { MachineType } from '../types/MachineType';
import type { MachineCategory } from '../types/MachineCategory';
import type { Location } from '~/modules/location/types/Location';
import type { Machine } from '../types/Machine';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import type { MachineDetails } from '../types/MachineDetails';
import Combobox from '~/components/ui/combobox/Combobox.vue';
import ComboboxAnchor from '~/components/ui/combobox/ComboboxAnchor.vue';
import ComboboxInput from '~/components/ui/combobox/ComboboxInput.vue';
import ComboboxTrigger from '~/components/ui/combobox/ComboboxTrigger.vue';
import { Check, ChevronsUpDown, TextCursorInput, TextSearch } from 'lucide-vue-next';
import ComboboxList from '~/components/ui/combobox/ComboboxList.vue';
import ComboboxEmpty from '~/components/ui/combobox/ComboboxEmpty.vue';
import ComboboxGroup from '~/components/ui/combobox/ComboboxGroup.vue';
import ComboboxItem from '~/components/ui/combobox/ComboboxItem.vue';
import ComboboxItemIndicator from '~/components/ui/combobox/ComboboxItemIndicator.vue';
import { cn } from '~/lib/utils';
import Button from '~/components/ui/button/Button.vue';
import ListMachinesOfLocation from '~/modules/location/components/ListMachinesOfLocation.vue';
import CreateMachineCategoryForm from './CreateMachineCategoryForm.vue';
import Textarea from '~/components/ui/textarea/Textarea.vue';

const props = withDefaults(defineProps<{
    machine: MachineDetails
    types: MachineType[],
    categories: MachineCategory[],
    locations: Location[]
    machines: Machine[],
    editMode: boolean
}>(), {
    editMode: false
})

const models = computed(() => {
    const seen = new Set()
    return props.machines
        .filter((m) => m.machine_model && !seen.has(m.machine_model) && seen.add(m.machine_model))
        .map((m) => ({
            value: m.machine_model,
            label: m.machine_model,
        }))
})

const isNewModel: Ref<boolean> = ref(false)

const manufacturers = computed(() => {
    const seen = new Set()
    return props.machines
        .filter((m) => m.manufacturer && !seen.has(m.manufacturer) && seen.add(m.manufacturer))
        .map((m) => ({
            value: m.manufacturer,
            label: m.manufacturer,
        }))
})

const isNewManufacturer: Ref<boolean> = ref(false)

const formSchema = toTypedSchema(z.object({
    name: z
        .string()
        .nonempty({ message: 'El nombre es obligatorio' }),
    type_id: z
        .number()
        .min(1, { message: 'El tipo es obligatorio' }),
    category_id: z
        .number()
        .min(1, { message: 'La categoria es obligatorio' }),
    machine_model: z
        .string()
        .nonempty({ message: 'El modelo es obligatorio' }),
    serial_number: z
        .string()
        .nonempty({ message: 'El numero de serie es obligatorio' }),
    manufacturer: z
        .string()
        .nonempty({ message: 'El fabricante es obligatorio' }),
    location_id: z
        .number()
        .min(1, { message: 'La ubicación es obligatorio' }),
    description: z
        .string()
        .optional(),
}))

const { handleSubmit, setFieldValue, resetForm } = useForm({
    validationSchema: formSchema,
    initialValues: {
        name: props.machine.name,
        type_id: props.machine.type.id,
        category_id: props.machine.category.id,
        machine_model: props.machine.machine_model,
        serial_number: props.machine.serial_number,
        manufacturer: props.machine.manufacturer,
        location_id: props.machine.location.id,
        description: props.machine.description ?? '',
    }
})

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
    resetForm
})

</script>

<style scoped></style>