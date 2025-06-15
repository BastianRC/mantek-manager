<template>
    <form class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="name">
                    <FormItem v-auto-animate>
                        <FormLabel>Nombre</FormLabel>
                        <FormControl v-if="editMode">
                            <Input type="text" placeholder="Edificio Principal" v-bind="componentField" />
                        </FormControl>

                        <p v-else class="text-sm">{{ location.name }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="type">
                    <FormItem v-auto-animate>
                        <FormLabel>Tipo</FormLabel>
                        <Select v-if="editMode" v-bind="componentField">
                            <FormControl>
                                <SelectTrigger>
                                    <SelectValue placeholder="Seleccionar tipo" />
                                </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem v-for="(type, index) in types" :key="index" :value="type.value">
                                        <div class="flex items-center gap-2">
                                            <span>{{ getType(type.value)?.icon }}</span>
                                            {{ type.label }}
                                        </div>
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>

                        <p v-else class="text-sm">{{ getType(location.type)?.label }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="operating_hours">
                    <FormItem v-auto-animate>
                        <FormLabel>Horario de Operación</FormLabel>
                        <FormControl v-if="editMode">
                            <Input type="text" placeholder="Lun-Vie 8:00-18:00" v-bind="componentField" />
                        </FormControl>

                        <p v-else class="text-sm">{{ location.operating_hours ?? '---' }}</p>

                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ value, handleChange }" name="floor">
                    <FormItem v-auto-animate>
                        <FormLabel>Planta/Nivel</FormLabel>
                        <FormControl v-if="editMode">
                            <NumberField :default-value="0" :model-value="value" @update:model-value="handleChange">
                                <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                </NumberFieldContent>
                            </NumberField>
                        </FormControl>

                        <p v-else class="text-sm">{{ location.floor }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>

        <div class="space-y-2">
            <FormField v-slot="{ componentField }" name="description">
                <FormItem v-auto-animate>
                    <FormLabel>Descripción</FormLabel>
                    <FormControl v-if="editMode">
                        <Textarea placeholder="Describe la ubicación y su propósito..." v-bind="componentField" />
                    </FormControl>

                    <p v-else class="text-sm">{{ location.description }}</p>

                    <FormMessage />
                </FormItem>
            </FormField>
        </div>

        <div class="space-y-2">
            <FormField v-slot="{ componentField }" name="address">
                <FormItem v-auto-animate>
                    <FormLabel>Dirección</FormLabel>
                    <FormControl v-if="editMode">
                        <Input type="text" placeholder="Calle Mayor 123, Madrid" v-bind="componentField" />
                    </FormControl>

                    <p v-else class="text-sm">{{ location.address }}</p>
                    <FormMessage />
                </FormItem>
            </FormField>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="latitude">
                    <FormItem v-auto-animate>
                        <FormLabel>Latitud</FormLabel>
                        <FormControl v-if="editMode">
                            <Input type="number" placeholder="40.4168" v-bind="componentField" />
                        </FormControl>

                        <p v-else class="text-sm">{{ location.latitude === 0 ? '---' : location.latitude }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="longitude">
                    <FormItem v-auto-animate>
                        <FormLabel>Logitud</FormLabel>
                        <FormControl v-if="editMode">
                            <Input type="number" placeholder="-3.7038" v-bind="componentField" />
                        </FormControl>

                        <p v-else class="text-sm">{{ location.longitude === 0 ? '---' : location.longitude }}</p>
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
import type { LocationDetails } from '../types/LocationDetails';
import type { LocationTypeOptions } from '../types/LocationTypeOptions';
import Select from '~/components/ui/select/Select.vue';
import SelectTrigger from '~/components/ui/select/SelectTrigger.vue';
import SelectValue from '~/components/ui/select/SelectValue.vue';
import SelectContent from '~/components/ui/select/SelectContent.vue';
import SelectGroup from '~/components/ui/select/SelectGroup.vue';
import SelectItem from '~/components/ui/select/SelectItem.vue';
import NumberField from '~/components/ui/number-field/NumberField.vue';
import NumberFieldContent from '~/components/ui/number-field/NumberFieldContent.vue';
import NumberFieldDecrement from '~/components/ui/number-field/NumberFieldDecrement.vue';
import NumberFieldInput from '~/components/ui/number-field/NumberFieldInput.vue';
import NumberFieldIncrement from '~/components/ui/number-field/NumberFieldIncrement.vue';
import Textarea from '~/components/ui/textarea/Textarea.vue';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';

const props = withDefaults(defineProps<{
    location: LocationDetails,
    types: LocationTypeOptions[],
    editMode: boolean
}>(), {
    editMode: false
})

const getType = (type: string) => {
    switch (type) {
        case "building":
            return {
                icon: '🏢',
                label: 'Edificio'
            };
        case "floor":
            return {
                icon: '🏢',
                label: 'Planta'
            };
        case "rooftop":
            return {
                icon: '🏢',
                label: 'Azotea'
            };
        case "room":
            return {
                icon: '🏠',
                label: 'Sala'
            };
        case "warehouse":
            return {
                icon: '🏭',
                label: 'Almacén'
            };
        case "datacenter":
            return {
                icon: '💻',
                label: 'Centro de Datos'
            };
        case "outdoor":
            return {
                icon: '🌳',
                label: 'Exterior'
            };
        case "parking":
            return {
                icon: '🚗',
                label: 'Parking'
            };
    }
};

const formSchema = toTypedSchema(z.object({
    name: z
        .string()
        .nonempty({ message: 'El nombre es obligatorio' }),
    type: z
        .string()
        .nonempty({ message: 'El tipo es obligatorio' }),
    floor: z
        .number()
        .optional(),
    description: z
        .string()
        .nonempty({ message: 'La descripción es obligatoria' }),
    address: z
        .string()
        .nonempty({ message: 'La dirección es obligatoria' }),
    latitude: z
        .coerce
        .number()
        .optional(),
    longitude: z
        .coerce
        .number()
        .optional(),
    operating_hours: z
        .string()
        .optional(),

}))

const { handleSubmit, resetForm } = useForm({
    validationSchema: formSchema,
    initialValues: {
        name: props.location.name,
        type: props.location.type,
        floor: props.location.floor ?? 0,
        description: props.location.description,
        address: props.location.address,
        latitude: props.location.latitude ?? 0,
        longitude: props.location.longitude ?? 0,
        operating_hours: props.location.operating_hours ?? ''
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