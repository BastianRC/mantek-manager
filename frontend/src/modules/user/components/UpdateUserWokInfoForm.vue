<template>
    <form @submit="" class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="role">
                    <FormItem v-auto-animate>
                        <FormLabel>Rol</FormLabel>
                        <Select v-if="editMode" v-bind="componentField">
                            <FormControl>
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecciona un rol" />
                                </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                                <!-- <SelectItem v-for="(role, index) in roles" :key="index" :value="role.name">
                                                {{ role.name }}
                                            </SelectItem> -->
                            </SelectContent>
                        </Select>

                        <p v-else class="text-sm">{{ user.last_name }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="department">
                    <FormItem v-auto-animate>
                        <FormLabel>Departamento</FormLabel>
                        <Select v-if="editMode" v-bind="componentField">
                            <FormControl>
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecciona un departamento" />
                                </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem value="Sistemas">Sistemas</SelectItem>
                                    <SelectItem value="Administracion">Administración</SelectItem>
                                    <SelectItem value="Mantenimiento">Mantenimiento</SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>

                        <p v-else class="text-sm">{{ user.department }}</p>
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
import type { UserDetails } from '../types/UserDetails';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import SelectTrigger from '~/components/ui/select/SelectTrigger.vue';
import SelectValue from '~/components/ui/select/SelectValue.vue';
import SelectContent from '~/components/ui/select/SelectContent.vue';
import SelectGroup from '~/components/ui/select/SelectGroup.vue';
import SelectItem from '~/components/ui/select/SelectItem.vue';
import Select from '~/components/ui/select/Select.vue';

const props = withDefaults(defineProps<{
    user: UserDetails
    editMode: boolean
}>(), {
    editMode: false
})

const formSchema = toTypedSchema(z.object({
    role: z
        .string()
        .optional(),
    department: z
        .string()
        .nonempty({ message: 'El departamento es obligatorio' })
}))

const { handleSubmit, resetForm } = useForm({
    validationSchema: formSchema,
    initialValues: {
        role: '',
        department: props.user.department
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