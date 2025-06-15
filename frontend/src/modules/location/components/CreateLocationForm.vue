<template>
    <form @submit="onSubmit" class="space-y-6">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Shield class="size-5" />
                            Información Básica
                        </CardTitle>
                        <CardDescription>Datos principales de la ubicación</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="name">
                                <FormItem v-auto-animate>
                                    <FormLabel>Nombre de la Ubicación *</FormLabel>
                                    <FormControl>
                                        <Input type="text" placeholder="Edificio Principal" v-bind="componentField" />
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
                                        <Select v-bind="componentField">
                                            <FormControl>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Seleccionar tipo" />
                                                </SelectTrigger>
                                            </FormControl>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectItem v-for="(type, index) in types" :key="index"
                                                        :value="type.value">
                                                        <div class="flex items-center gap-2">
                                                            <span>{{ getType(type.value)?.icon }}</span>
                                                            {{ type.label }}
                                                        </div>
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>

                            <div class="space-y-2">
                                <FormField v-slot="{ componentField }" name="floor">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Planta/Nivel</FormLabel>
                                        <FormControl>
                                            <NumberField :default-value="0" v-bind="componentField">
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
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="description">
                                <FormItem v-auto-animate>
                                    <FormLabel>Descripción *</FormLabel>
                                    <FormControl>
                                        <Textarea placeholder="Describe la ubicación y su propósito..."
                                            v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="address">
                                <FormItem v-auto-animate>
                                    <FormLabel>Dirección *</FormLabel>
                                    <FormControl>
                                        <Input type="text" placeholder="Calle Mayor 123, Madrid"
                                            v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <FormField v-slot="{ componentField }" name="latitude">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Latitud</FormLabel>
                                        <FormControl>
                                            <Input type="text" placeholder="40.4168" v-bind="componentField" />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>

                            <div class="space-y-2">
                                <FormField v-slot="{ componentField }" name="longitude">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Logitud</FormLabel>
                                        <FormControl>
                                            <Input type="text" placeholder="-3.7038" v-bind="componentField" />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>
                        </div>
                        <div v-if="values.type" class="p-3 bg-muted rounded-lg">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">{{ getType(values.type)?.icon }}</span>
                                <span class="font-medium">{{ getType(values.type)?.label }}</span>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Zonas y Sistemas</CardTitle>
                        <CardDescription>Subdivisiones internas y sistemas instalados</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <div class="space-y-4">
                            <Label>Zonas Internas</Label>
                            <div class="flex gap-2 mt-2">
                                <Input type="text" v-model="newZone" @keypress.enter.prevent="handleAddZone"
                                    class="flex-1" />
                                <Button type="button" @click="handleAddZone">
                                    <Plus class="size-4" />
                                </Button>
                            </div>
                            <div class="flex flex-wrap gap-2 mt-3">
                                <Badge v-for="(zone, index) in values.zones" :key="index"
                                    class="flex items-center gap-2" variant="secondary">
                                    {{ zone }}
                                    <Button type="button" variant="ghost" :size="null"
                                        class="h-auto p-1 text-muted-foreground hover:text-destructive"
                                        @click="setFieldValue('zones', (values.zones ?? []).filter(z => z !== zone));">
                                        <X class="size-3" />
                                    </Button>
                                </Badge>
                            </div>
                        </div>

                        <div>
                            <FormField name="systems">
                                <FormItem v-auto-animate>
                                    <FormControl>
                                        <Label>Sistemas Instalados</Label>
                                        <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-3 mt-3">
                                            <FormField v-for="(system) in systems ?? []" :key="system.value"
                                                name="systems" type="checkbox" :value="system.value"
                                                :unchecked-value="false" v-slot="{ value, handleChange }">
                                                <div class="flex items-center space-x-2">
                                                    <Checkbox :id="system.value"
                                                        :model-value="(value).includes(system.value)"
                                                        @update:model-value="handleChange" />
                                                    <FormLabel :for="system.value">
                                                        {{ system.label }}
                                                    </FormLabel>
                                                </div>
                                            </FormField>
                                        </div>

                                        <div v-if="values.systems" class="flex flex-wrap gap-2 mt-3">
                                            <Badge v-for="(system) in values.systems" :key="system" variant="outline">
                                               {{ systems.find((val) => val.value === system)?.label }}
                                            </Badge>
                                        </div>
                                    </FormControl>
                                </FormItem>
                            </FormField>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <div class="space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Users class="size-5" />
                            Responsable
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="manager_id">
                                <FormItem v-auto-animate>
                                    <FormLabel>Responsable *</FormLabel>
                                    <Select v-bind="componentField">
                                        <FormControl>
                                            <SelectTrigger>
                                                <SelectValue placeholder="Seleccionar tipo" />
                                            </SelectTrigger>
                                        </FormControl>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectItem v-for="(user) in users" :key="user.id" :value="user.id">
                                                    <div class="flex items-center gap-2">
                                                        {{ `${user.first_name} ${user.last_name}` }}
                                                    </div>
                                                </SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                    <FormMessage />


                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <Label for="email">Email</Label>
                            <Input id="email" type="text" placeholder="example@hotmail.com"
                                :value="users.find((user) => user.id === values.manager_id)?.email" :readonly="true" />
                        </div>

                        <div class="space-y-2">
                            <Label for="phone">Telefono</Label>
                            <Input id="phone" type="text" placeholder="example@hotmail.com"
                                :value="users.find((user) => user.id === values.manager_id)?.phone" :readonly="true" />
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Shield class="size-5" />
                            Seguridad
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="emergency_contact">
                                <FormItem v-auto-animate>
                                    <FormLabel>Nombre del contacto</FormLabel>
                                    <FormControl>
                                        <Input type="text" placeholder="John Doe"
                                            v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="emergency_phone">
                                <FormItem v-auto-animate>
                                    <FormLabel>Teléfono de Emergencia</FormLabel>
                                    <FormControl>
                                        <Input type="text" placeholder="+34 698765432" v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="access_requirements">
                                <FormItem v-auto-animate>
                                    <FormLabel>Requisitos de Acceso</FormLabel>
                                    <FormControl>
                                        <Textarea placeholder="Tarjeta de acceso, autorización especial..."
                                            v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Información Adicional</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <FormField v-slot="{ componentField }" name="operating_hours">
                            <FormItem v-auto-animate>
                                <FormLabel>Horario de Operación</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="Lun-Vie 8:00-18:00" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                    </CardContent>
                </Card>
            </div>
        </div>

        <Card>
            <CardHeader>
                <CardTitle>Notas Adicionales</CardTitle>
            </CardHeader>
            <CardContent>
                <FormField v-slot="{ componentField }" name="notes">
                    <FormItem v-auto-animate>
                        <FormControl>
                            <Textarea
                                placeholder="Información adicional, observaciones especiales, historial relevante..."
                                v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </CardContent>
        </Card>

        <div class="flex items-center justify-end gap-4">
            <Button type="button" variant="outline" @click="$router.back">
                Cancelar
            </Button>
            <Button type="submit" class="min-w-32">
                <Save v-if="!loading" class="mr-2 size-4" />
                <Loader2 v-else class="mr-2 size-4 animate-spin" />
                Crear Ubicación
            </Button>
        </div>
    </form>
</template>

<script setup lang="ts">
import { Loader2, Plus, Save, Shield, Users, X } from 'lucide-vue-next';
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
import type { LocationTypeOptions } from '../types/LocationTypeOptions';
import NumberField from '~/components/ui/number-field/NumberField.vue';
import NumberFieldContent from '~/components/ui/number-field/NumberFieldContent.vue';
import NumberFieldDecrement from '~/components/ui/number-field/NumberFieldDecrement.vue';
import NumberFieldInput from '~/components/ui/number-field/NumberFieldInput.vue';
import NumberFieldIncrement from '~/components/ui/number-field/NumberFieldIncrement.vue';
import Textarea from '~/components/ui/textarea/Textarea.vue';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import Button from '~/components/ui/button/Button.vue';
import Badge from '~/components/ui/badge/Badge.vue';
import Label from '~/components/ui/label/Label.vue';
import type { LocationSystemOptions } from '../types/LocationSystemOptions';
import Checkbox from '~/components/ui/checkbox/Checkbox.vue';
import type { User } from '~/modules/user/types/User';

defineProps<{
    loading?: boolean,
    types: LocationTypeOptions[],
    systems: LocationSystemOptions[],
    users: User[]
}>()

const emit = defineEmits(['submit'])

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

const newZone: Ref<string> = ref('')

const handleAddZone = () => {
    const zone = newZone.value.trim();
    const zones = values.zones ?? [];

    if (zone && !zones.some(z => z.toLowerCase() === zone.toLowerCase())) {
        setFieldValue('zones', [...zones, zone]);
        newZone.value = '';
    }
}
const formSchema = toTypedSchema(z.object({
    name: z
        .string()
        .nonempty({ message: 'El nombre es obligatorio' }),
    type: z
        .string()
        .nonempty({ message: 'El tipo es obligatorio' }),
    floor: z
        .coerce
        .number()
        .optional(),
    description: z
        .string()
        .nonempty({ message: 'La descripción es obligatoria' }),
    address: z
        .string()
        .nonempty({ message: 'La dirección es obligatoria' }),
    latitude: z
        .string()
        .optional(),
    longitude: z
        .string()
        .optional(),
    zones: z
        .array(z.string())
        .optional(),
    systems: z
        .array(z.string())
        .optional(),
    manager_id: z
        .number()
        .min(1, 'El responsable debe ser válido'),
    emergency_contact: z
        .string()
        .optional(),
    emergency_phone: z
        .string()
        .optional(),
    access_requirements: z
        .string()
        .optional(),
    operating_hours: z
        .string()
        .optional(),

}))

const { handleSubmit, setFieldValue, values } = useForm({
    validationSchema: formSchema,
    initialValues: {
        name: '',
        type: '',
        floor: 0,
        description: '',
        address: '',
        latitude: '',
        longitude: '',
        zones: [],
        systems: [],
        manager_id: 0,
        emergency_contact: '',
        emergency_phone: '',
        access_requirements: '',
        operating_hours: ''
    }
})

const onSubmit = handleSubmit((values) => {
    emit('submit', values)
})

</script>

<style scoped></style>