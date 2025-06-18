<template>
    <form class="space-y-6">
        <div class="space-y-2">
            <FormField v-slot="{ componentField }" name="name">
                <FormItem v-auto-animate>
                    <FormLabel>Nombre de Rol</FormLabel>
                    <FormControl v-if="editMode">
                        <Input type="text" placeholder="Administrator" v-bind="componentField" />
                    </FormControl>

                    <p v-else class="text-sm">{{ role.name }}</p>

                    <FormMessage />
                </FormItem>
            </FormField>
        </div>

        <div class="space-y-2">
            <FormField v-slot="{ componentField }" name="description">
                <FormItem v-auto-animate>
                    <FormLabel>Descripción</FormLabel>
                    <FormControl v-if="editMode">
                        <Textarea placeholder="Describe las responsabilidades y alcance de este rol..."
                            v-bind="componentField" />
                    </FormControl>

                    <p v-else class="text-sm">{{ role.description }}</p>

                    <FormMessage />
                </FormItem>
            </FormField>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <Label>Fecha de Creación</Label>
                <p class="text-sm">{{ role.created_at }}</p>
            </div>
            <div class="space-y-2">
                <Label>Última Actualización</Label>
                <p class="text-sm">{{ role.updated_at }}</p>
            </div>
            <div class="space-y-2">
                <Label>Creado por</Label>
                <p class="text-sm">{{ role.created_by ? `${role.created_by.name}` : 'Sistema' }}</p>
            </div>
            <div class="space-y-2">
                <Label>Usuarios Asignados</Label>
                <p class="text-sm">{{ role.users ? role.users.length : 0 }} Usuario/s</p>
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
import Textarea from '~/components/ui/textarea/Textarea.vue';
import type { RoleDetails } from '../types/RoleDetails';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import Label from '~/components/ui/label/Label.vue';

const props = withDefaults(defineProps<{
    role: RoleDetails
    editMode: boolean
}>(), {
    editMode: false
})


const formSchema = toTypedSchema(z.object({
    name: z
        .string()
        .nonempty({ message: 'El nombre es obligatorio' }),
    description: z
        .string()
        .nonempty({ message: 'La descripción ses obligatoria' }),
}))


const { handleSubmit, resetForm } = useForm({
    validationSchema: formSchema,
    initialValues: {
        name: props.role.name,
        description: props.role.description,
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
