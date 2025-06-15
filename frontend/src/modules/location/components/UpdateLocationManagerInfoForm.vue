<template>
    <form class="space-y-6">
        <FormField v-slot="{ componentField }" name="manager_id">
            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <Avatar class="size-12">
                        <AvatarImage :src="user?.avatar_url ?? ''" />

                        <AvatarFallback>{{ getInitials(`${user?.first_name} ${user?.last_name}`) }}</AvatarFallback>
                    </Avatar>
                    <div>
                        <p class="font-medium">{{ `${user?.first_name} ${user?.last_name}` }}</p>
                        <p class="text-sm text-muted-foreground">Responsable de ubicación</p>
                    </div>
                </div>
                <div class="space-y-2  mb-5">
                    <div class="flex items-center gap-2">
                        <Mail class="h-4 w-4 text-muted-foreground" />
                        <span class="text-sm">{{ user?.email }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <Phone class="h-4 w-4 text-muted-foreground" />
                        <span class="text-sm">{{ user?.phone }}</span>
                    </div>
                </div>
            </div>

            <FormItem v-if="editMode" v-auto-animate>
                <FormLabel>Cambiar Responsable</FormLabel>
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
            </FormItem>
        </FormField>

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
import Select from '~/components/ui/select/Select.vue';
import SelectTrigger from '~/components/ui/select/SelectTrigger.vue';
import SelectValue from '~/components/ui/select/SelectValue.vue';
import SelectContent from '~/components/ui/select/SelectContent.vue';
import SelectGroup from '~/components/ui/select/SelectGroup.vue';
import SelectItem from '~/components/ui/select/SelectItem.vue';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import type { User } from '~/modules/user/types/User';
import Label from '~/components/ui/label/Label.vue';
import Avatar from '~/components/ui/avatar/Avatar.vue';
import AvatarImage from '~/components/ui/avatar/AvatarImage.vue';
import AvatarFallback from '~/components/ui/avatar/AvatarFallback.vue';
import { Mail, Phone } from 'lucide-vue-next';
import { getInitials } from '~/lib/utils';

const props = withDefaults(defineProps<{
    location: LocationDetails,
    users: User[]
    editMode: boolean
}>(), {
    editMode: false
})

const user = computed(() => props.users.find((user) => user.id === values.manager_id))

const formSchema = toTypedSchema(z.object({
    manager_id: z
        .number()
        .min(1, 'El responsable debe ser válido'),

}))

const { handleSubmit, resetForm, values } = useForm({
    validationSchema: formSchema,
    initialValues: {
        manager_id: props.location.manager?.id
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