<template>
    <form class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="emergency_contact">
                    <FormItem v-auto-animate>
                        <FormLabel>Nombre del contacto</FormLabel>
                        <FormControl v-if="editMode">
                            <Input type="text" placeholder="John Doe" v-bind="componentField" />
                        </FormControl>

                        <p v-else class="text-sm">{{ location.emergency_contact ?? '---' }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="emergency_phone">
                    <FormItem v-auto-animate>
                        <FormLabel>Teléfono de Emergencia</FormLabel>
                        <FormControl v-if="editMode">
                            <Input type="text" placeholder="+34 698765432" v-bind="componentField" />
                        </FormControl>

                        <p v-else class="text-sm">{{ location.emergency_phone ?? '---' }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>

        <div class="space-y-2">
            <FormField v-slot="{ componentField }" name="access_requirements">
                <FormItem v-auto-animate>
                    <FormLabel>Requisitos de Acceso</FormLabel>
                    <FormControl v-if="editMode">
                        <Textarea placeholder="Tarjeta de acceso, autorización especial..." v-bind="componentField" />
                    </FormControl>

                    <p v-else class="text-sm">{{ location.access_requirements ?? '---' }}</p>
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
import type { LocationDetails } from '../types/LocationDetails';
import Textarea from '~/components/ui/textarea/Textarea.vue';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';

const props = withDefaults(defineProps<{
    location: LocationDetails,
    editMode: boolean
}>(), {
    editMode: false
})

const formSchema = toTypedSchema(z.object({
    emergency_contact: z
        .string()
        .optional(),
    emergency_phone: z
        .string()
        .optional(),
    access_requirements: z
        .string()
        .optional(),

}))

const { handleSubmit, resetForm } = useForm({
    validationSchema: formSchema,
    initialValues: {
        emergency_contact: props.location.emergency_contact ?? '',
        emergency_phone: props.location.emergency_phone ?? '',
        access_requirements: props.location.access_requirements ?? '',
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