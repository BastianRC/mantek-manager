<template>
    <form @submit="" class="space-y-6">
        <FormField name="avatar_file">
            <FormItem v-auto-animate>
                <FormControl>
                    <div class="flex flex-col items-center gap-2">
                        <Avatar class="size-24" :class="{ 'mb-4': editMode }">
                            <AvatarImage :src="editMode ? previewUrl ?? user.avatar_url ?? '' : user.avatar_url ?? ''"
                                alt="Avatar" />
                            <AvatarFallback class="text-lg">{{ getInitials(`${user.first_name} ${user.last_name}`)
                                }}</AvatarFallback>
                        </Avatar>
                        <Input v-if="editMode" type="file" accept="image/*" ref="fileInput"
                            @change="handleFileChange" />
                    </div>
                </FormControl>
                <FormMessage />
            </FormItem>
        </FormField>

        <div>
            <h3 class="font-semibold text-lg">{{ `${user.first_name} ${user.last_name}` }}</h3>
            <p class="text-muted-foreground">Administrador</p>

        </div>

        <FormField v-slot="{ value, handleChange }" name="is_active">
            <FormItem>
                <FormControl v-if="editMode">
                    <div class="flex items-center justify-center gap-4">
                        <span :class="{ 'font-semibold': !values.is_active }">Inactivo</span>
                        <Switch :model-value="value" @update:model-value="handleChange" />
                        <span :class="{ 'font-semibold': values.is_active }">Activo</span>
                    </div>
                </FormControl>

                <div v-else>
                    <Badge :class="getStatusColor(user.is_active)">
                        <span class="text-sm px-2">{{ user.is_active ? "Activo" : "Inactivo" }}</span>
                    </Badge>
                </div>
                <FormMessage />
            </FormItem>
        </FormField>
    </form>
</template>

<script setup lang="ts">
import { FormField } from '~/components/ui/form';
import FormControl from '~/components/ui/form/FormControl.vue';
import FormItem from '~/components/ui/form/FormItem.vue';
import FormMessage from '~/components/ui/form/FormMessage.vue';
import type { UserDetails } from '../types/UserDetails';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import Avatar from '~/components/ui/avatar/Avatar.vue';
import AvatarImage from '~/components/ui/avatar/AvatarImage.vue';
import AvatarFallback from '~/components/ui/avatar/AvatarFallback.vue';
import Input from '~/components/ui/input/Input.vue';
import { getInitials } from '~/lib/utils';
import Switch from '~/components/ui/switch/Switch.vue';
import Badge from '~/components/ui/badge/Badge.vue';

const props = withDefaults(defineProps<{
    user: UserDetails
    editMode: boolean
}>(), {
    editMode: false
})

const previewUrl = ref<string | null>(props.user.avatar_url)
const selectedFile = ref<File | null>(null)

const formSchema = toTypedSchema(z.object({
    avatar_file: z
        .instanceof(File)
        .optional(),
    is_active: z
        .boolean()
}))

const { handleSubmit, setFieldValue, resetForm, values } = useForm({
    validationSchema: formSchema,
    initialValues: {
        is_active: props.user.is_active
    }
})

const handleFileChange = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0]
    if (file) {
        selectedFile.value = file
        setFieldValue('avatar_file', file)
        previewUrl.value = URL.createObjectURL(file)
    } else {
        selectedFile.value = null
        setFieldValue('avatar_file', undefined)
        previewUrl.value = null
    }
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