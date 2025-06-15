<template>
    <div class="space-y-2">
        <FormField v-slot="{ componentField }" name="assignee_id">
            <FormItem v-auto-animate>
                <div class="flex items-center gap-3">
                    <Avatar class="size-12">
                        <AvatarImage :src="assigneeUser?.avatar_url ?? ''" />
                        <AvatarFallback>{{ getInitials(`${assigneeUser?.first_name} ${assigneeUser?.last_name}`) }}
                        </AvatarFallback>
                    </Avatar>
                    <div>
                        <p class="font-medium">{{ `${assigneeUser?.first_name} ${assigneeUser?.last_name}` }}</p>
                        <p class="text-sm text-muted-foreground">Técnico asignado</p>
                    </div>
                </div>

                <FormLabel v-if="editMode" class="mt-3">Técnico Asignado</FormLabel>
                <div v-if="editMode" class="flex items-center gap-2">
                    <Select v-bind="componentField">
                        <FormControl>
                            <SelectTrigger>
                                <SelectValue placeholder="Seleccionar técnico" />
                            </SelectTrigger>
                        </FormControl>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem v-for="(user) in users.filter(val => val.is_active)" :key="user.id"
                                    :value="user.id">
                                    {{ `${user.first_name} ${user.last_name}` }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <FormMessage />
            </FormItem>
        </FormField>
    </div>
    <div class="space-y-2">
        <div class="flex items-center gap-2">
            <UserIcon class="size-4 text-muted-foreground" />
            <span class="text-sm">Creado por: {{ workOrder.created_by.name }}</span>
        </div>
        <div class="flex items-center gap-2">
            <Calendar class="size-4 text-muted-foreground" />
            <span class="text-sm">Fecha de creación: {{ workOrder.created_at }}</span>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { User } from '~/modules/user/types/User';
import type { WorkOrderDetails } from '../types/WorkOrderDetails';
import { getInitials } from '~/lib/utils';
import Avatar from '~/components/ui/avatar/Avatar.vue';
import AvatarImage from '~/components/ui/avatar/AvatarImage.vue';
import AvatarFallback from '~/components/ui/avatar/AvatarFallback.vue';
import { Calendar, Clock, UserIcon } from 'lucide-vue-next';
import { FormField } from '~/components/ui/form';
import FormItem from '~/components/ui/form/FormItem.vue';
import FormLabel from '~/components/ui/form/FormLabel.vue';
import Select from '~/components/ui/select/Select.vue';
import FormControl from '~/components/ui/form/FormControl.vue';
import SelectTrigger from '~/components/ui/select/SelectTrigger.vue';
import SelectValue from '~/components/ui/select/SelectValue.vue';
import SelectContent from '~/components/ui/select/SelectContent.vue';
import SelectGroup from '~/components/ui/select/SelectGroup.vue';
import SelectItem from '~/components/ui/select/SelectItem.vue';
import FormMessage from '~/components/ui/form/FormMessage.vue';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';

const props = withDefaults(defineProps<{
    workOrder: WorkOrderDetails
    users: User[]
    editMode: boolean
}>(), {
    editMode: false
})

const assigneeUser = computed(() => {
    return props.users.find((user) => user.id === values.assignee_id) ?? null
})

const formSchema = toTypedSchema(z.object({
    assignee_id: z
        .number()
        .min(1, { message: 'El tecnico asignado es obligatorio' }),
}))

const { handleSubmit, resetForm, values } = useForm({
    validationSchema: formSchema,
    initialValues: {
        assignee_id: props.workOrder.assignee?.id
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