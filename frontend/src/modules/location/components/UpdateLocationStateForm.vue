<template>
    <form class="space-y-6">
        <div class="flex flex-col items-center text-center space-y-4">
            <div class="p-4 bg-blue-100 rounded-lg text-blue-600">
                <component class="size-8" :is="getType(location.type)?.icon"></component>
            </div>
            <div>
                <h3 class="font-semibold text-lg">{{ location.name }}</h3>
                <p class="text-muted-foreground">{{ getType(location.type)?.label }}</p>
            </div>
            <FormField v-slot="{ value, handleChange }" name="is_active">
                <FormItem>
                    <div class="flex flex-col items-center gap-4">
                        <div class="flex flex-col items-center">
                            <FormControl v-if="editMode">
                                <div class="flex items-center justify-center gap-4">
                                    <span :class="{ 'font-semibold': !values.is_active }">Inactivo</span>
                                    <Switch :model-value="value" @update:model-value="handleChange" />
                                    <span :class="{ 'font-semibold': values.is_active }">Activo</span>
                                </div>
                            </FormControl>

                            <div v-else>
                                <Badge :class="getStatusColor(location.is_active)">
                                    <span class="text-sm px-2">{{ getStatusText(location.is_active) }}</span>
                                </Badge>
                            </div>
                        </div>
                    </div>
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
import type { LocationDetails } from '../types/LocationDetails';
import type { LocationSystemOptions } from '../types/LocationSystemOptions';
import Label from '~/components/ui/label/Label.vue';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import Checkbox from '~/components/ui/checkbox/Checkbox.vue';
import Badge from '~/components/ui/badge/Badge.vue';
import { Building, Cpu, Factory, Home, MapPin, Plus, Warehouse, X } from 'lucide-vue-next';
import Button from '~/components/ui/button/Button.vue';
import Input from '~/components/ui/input/Input.vue';
import Switch from '~/components/ui/switch/Switch.vue';
import FormMessage from '~/components/ui/form/FormMessage.vue';

const props = withDefaults(defineProps<{
    location: LocationDetails,
    editMode: boolean
}>(), {
    editMode: false
})

const getType = (type: string) => {
    switch (type) {
        case "building":
            return {
                emoji: '🏢',
                icon: Building,
                label: 'Edificio'
            };
        case "floor":
            return {
                emoji: '🏢',
                icon: Building,
                label: 'Planta'
            };
        case "rooftop":
            return {
                emoji: '🏢',
                icon: Building,
                label: 'Azotea'
            };
        case "room":
            return {
                emoji: '🏠',
                icon: Home,
                label: 'Sala'
            };
        case "warehouse":
            return {
                emoji: '🏭',
                icon: Warehouse,
                label: 'Almacén'
            };
        case "datacenter":
            return {
                emoji: '💻',
                icon: Cpu,
                label: 'Centro de Datos'
            };
        case "outdoor":
            return {
                emoji: '🌳',
                icon: MapPin,
                label: 'Exterior'
            };
        case "parking":
            return {
                emoji: '🚗',
                icon: Factory,
                label: 'Parking'
            };
    }
};

const getStatusColor = (status: boolean) => {
    switch (status) {
        case true:
            return "bg-green-100 text-green-800 border-green-200"
        case false:
            return "bg-red-100 text-red-800 border-red-200"
        default:
            return "bg-gray-100 text-gray-800 border-gray-200"
    }
}

const getStatusText = (status: boolean) => {
    switch (status) {
        case true:
            return "Activa"
        case false:
            return "Inactivo"
        default:
            return status
    }
}

const formSchema = toTypedSchema(z.object({
    is_active: z
        .boolean()

}))

const { handleSubmit, resetForm, values } = useForm({
    validationSchema: formSchema,
    initialValues: {
        is_active: props.location.is_active
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