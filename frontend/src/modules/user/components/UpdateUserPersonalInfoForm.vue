<template>
    <form @submit="" class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="first_name">
                    <FormItem v-auto-animate>
                        <FormLabel>Nombre</FormLabel>
                        <FormControl v-if="editMode">
                            <Input type="text" placeholder="John" v-bind="componentField" />
                        </FormControl>

                        <p v-else class="text-sm">{{ user.first_name }}</p>

                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="last_name">
                    <FormItem v-auto-animate>
                        <FormLabel>Apellidos</FormLabel>
                        <FormControl v-if="editMode">
                            <Input type="text" placeholder="Doe" v-bind="componentField" />
                        </FormControl>

                        <p v-else class="text-sm">{{ user.last_name }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="email">
                    <FormItem v-auto-animate>
                        <FormLabel>Email</FormLabel>
                        <FormControl v-if="editMode">
                            <Input type="email" placeholder="john.doe@example.com" v-bind="componentField" />
                        </FormControl>

                        <p v-else class="text-sm">{{ user.email }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="phone">
                    <FormItem v-auto-animate>
                        <FormLabel>Telefono</FormLabel>
                        <FormControl v-if="editMode">
                            <Input type="text" placeholder="+34 666778899" v-bind="componentField" />
                        </FormControl>

                        <p v-else class="text-sm">{{ user.phone }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>

        <div class="space-y-2">
            <FormField v-slot="{ componentField }" name="notes">
                <FormItem v-auto-animate>
                    <FormLabel>Notas</FormLabel>
                    <FormControl v-if="editMode">
                        <Textarea placeholder="Información adicional sobre el usuario..." class="resize-none"
                            v-bind="componentField" />
                    </FormControl>

                    <p v-else class="text-sm">{{ user.notes ?? '---' }}</p>
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
import type { UserDetails } from '../types/UserDetails';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import Textarea from '~/components/ui/textarea/Textarea.vue';

const props = withDefaults(defineProps<{
    user: UserDetails
    editMode: boolean
}>(), {
    editMode: false
})

const formSchema = toTypedSchema(z.object({
    first_name: z
        .string()
        .nonempty({ message: 'El nombre es obligatorio' }),
    last_name: z
        .string()
        .nonempty({ message: 'Los apellidos son obligatorios' }),
    email: z
        .string()
        .nonempty({ message: 'El email es obligatorio' })
        .email({ message: 'El email no es válido' }),
    phone: z
        .string()
        .nonempty({ message: 'El telefono es obligatorio' }),
    notes: z
        .string()
        .optional(),
    avatar_file: z
        .instanceof(File)
        .optional(),
}))

const { handleSubmit, resetForm } = useForm({
    validationSchema: formSchema,
    initialValues: {
        first_name: props.user.first_name,
        last_name: props.user.last_name,
        email: props.user.email,
        phone: props.user.phone,
        notes: props.user.notes ?? ''
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