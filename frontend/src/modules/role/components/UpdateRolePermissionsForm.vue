<template>
    <form class="space-y-6">
        <p v-if="errors.permissions" class="text-sm text-red-500 mt-1">{{ errors.permissions }}</p>
        <div v-for="(category, categoryKey) in PERMISSION_CATEGORIES" :key="categoryKey" class="space-y-3">
            <h4 class="font-medium text-sm">{{ category.name }}</h4>
            <FormField name="permissions">
                <FormItem v-auto-animate>
                    <FormControl>
                        <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-3 ml-6">
                            <FormField class="space-y-1" v-for="permission in category.permissions"
                                v-slot="{ value, handleChange }" :key="permission.id" type="checkbox"
                                :value="permission.id" :unchecked-value="false" name="permissions">
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-center space-x-2 ">
                                        <Checkbox :id="permission.id" :model-value="value.includes(permission.id)"
                                            @update:model-value="handleChange" :disabled="!editMode" />
                                        <FormLabel :for="permission.id">
                                            {{ permission.name }}
                                        </FormLabel>
                                    </div>
                                </div>
                            </FormField>
                        </div>
                    </FormControl>
                </FormItem>
            </FormField>
            <Separator />
        </div>
    </form>
</template>

<script setup lang="ts">
import { PERMISSION_CATEGORIES } from '~/modules/shared/constants/permissions';
import type { RoleDetails } from '../types/RoleDetails';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { FormField } from '~/components/ui/form';
import FormItem from '~/components/ui/form/FormItem.vue';
import FormControl from '~/components/ui/form/FormControl.vue';
import Checkbox from '~/components/ui/checkbox/Checkbox.vue';
import FormLabel from '~/components/ui/form/FormLabel.vue';
import { useForm } from 'vee-validate';
import Separator from '~/components/ui/separator/Separator.vue';

const props = withDefaults(defineProps<{
    role: RoleDetails
    editMode: boolean
}>(), {
    editMode: false
})


const formSchema = toTypedSchema(z.object({
    permissions: z.array(z.string()).refine(value => value.length > 0, {
        message: 'Debes seleccionar al menos un permiso.',
    }),
}))


const { handleSubmit, resetForm, errors } = useForm({
    validationSchema: formSchema,
    initialValues: {
        permissions: props.role.permissions.map((permission) => permission.name)
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