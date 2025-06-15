<template>
    <form class="space-y-6">
        <div class="flex flex-col items-center text-center space-y-4">
            <div :class="`p-4 rounded-lg ${getColorClasses(role.color)}`">
                <Shield className="size-8" />
            </div>
            <div>
                <h3 class="font-semibold text-lg">{{ role.name }}</h3>
                <p class="text-muted-foreground text-sm">{{ role.description }}</p>
            </div>

            <FormField v-slot="{ value, handleChange }" name="is_active">
                <FormItem>
                    <div class="flex flex-col items-center gap-4">
                        <Badge :class="`${getColorClasses(role.color)} border`">
                            <span class="text-sm px-2">{{ role.permissions.length }} permisos</span>
                        </Badge>
                        <div class="flex flex-col items-center">
                            <FormControl v-if="editMode">
                                <div class="flex items-center justify-center gap-4">
                                    <span :class="{ 'font-semibold': !values.is_active }">Inactivo</span>
                                    <Switch :model-value="value" @update:model-value="handleChange" />
                                    <span :class="{ 'font-semibold': values.is_active }">Activo</span>
                                </div>
                            </FormControl>

                            <div v-else>
                                <Badge :class="getStatusColor(role.is_active)">
                                    <span class="text-sm px-2">{{ role.is_active ? "Activo" : "Inactivo" }}</span>
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
import { Shield } from 'lucide-vue-next';
import type { RoleDetails } from '../types/RoleDetails';
import { FormField } from '~/components/ui/form';
import FormItem from '~/components/ui/form/FormItem.vue';
import FormControl from '~/components/ui/form/FormControl.vue';
import Badge from '~/components/ui/badge/Badge.vue';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import FormMessage from '~/components/ui/form/FormMessage.vue';
import Switch from '~/components/ui/switch/Switch.vue';

const props = withDefaults(defineProps<{
    role: RoleDetails
    editMode: boolean
}>(), {
    editMode: false
})

const getColorClasses = (color: string) => {
    const colors = {
        purple: "bg-purple-100 text-purple-800 border-purple-200",
        blue: "bg-blue-100 text-blue-800 border-blue-200",
        green: "bg-green-100 text-green-800 border-green-200",
        orange: "bg-orange-100 text-orange-800 border-orange-200",
        gray: "bg-gray-100 text-gray-800 border-gray-200",
        slate: "bg-slate-100 text-slate-800 border-slate-200",
    }
    return colors[color as keyof typeof colors] || colors.gray
}

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

const formSchema = toTypedSchema(z.object({
    is_active: z
        .boolean()
}))

const { handleSubmit, resetForm, values } = useForm({
    validationSchema: formSchema,
    initialValues: {
        is_active: props.role.is_active
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