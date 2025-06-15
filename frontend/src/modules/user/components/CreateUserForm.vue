<template>
    <form @submit="onSubmit" class="space-y-6">
        <div class="grid gap-5 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <User class="size-5" />
                            Información Personal
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <FormField v-slot="{ componentField }" name="first_name">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Nombre *</FormLabel>
                                        <FormControl>
                                            <Input type="text" placeholder="John" v-bind="componentField" />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>

                            <div class="space-y-2">
                                <FormField v-slot="{ componentField }" name="last_name">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Apellidos *</FormLabel>
                                        <FormControl>
                                            <Input type="text" placeholder="Doe" v-bind="componentField" />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="email">
                                <FormItem v-auto-animate>
                                    <FormLabel>Email *</FormLabel>
                                    <FormControl>
                                        <Input type="email" placeholder="john.doe@example.com"
                                            v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="phone">
                                <FormItem v-auto-animate>
                                    <FormLabel>Telefono *</FormLabel>
                                    <FormControl>
                                        <Input type="text" placeholder="+34 666778899" v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>


                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="password">
                                <FormItem v-auto-animate>
                                    <FormLabel>Contraseña *</FormLabel>
                                    <FormControl>
                                        <div class="relative items-center">
                                            <Input :type="showPassword ? 'text' : 'password'" placeholder="Contraseña"
                                                v-bind="componentField" />

                                            <Button variant="ghost"
                                                class="absolute end-0 inset-y-0 flex items-center justify-center px-2"
                                                @click.prevent="showPassword = !showPassword">
                                                <component :is="showPassword ? EyeOff : Eye"
                                                    class="size-4 text-muted-foreground" />
                                            </Button>
                                        </div>
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="notes">
                                <FormItem v-auto-animate>
                                    <FormLabel>Notas</FormLabel>
                                    <FormControl>
                                        <Textarea placeholder="Información adicional sobre el usuario..."
                                            class="resize-none" v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <div class="space-y-6">
                <!-- TODO: SE AÑADIRA CUANDO EL BACKEND LO PERMITA  -->
                <!-- <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Shield class="size-5" />
                            Avatar
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <FormField name="avatar_file">
                            <FormItem v-auto-animate>
                                <FormLabel>Imagen</FormLabel>
                                <FormControl>
                                    <div class="flex items-center gap-2">
                                        <Avatar class="size-14">
                                            <AvatarImage :src="previewUrl ?? ''" alt="Avatar" />
                                            <AvatarFallback>{{ values.first_name || values.last_name ?
                                                getInitials(`${values.first_name} ${values.last_name}`) : 'N/A' }}
                                            </AvatarFallback>
                                        </Avatar>
                                        <Input type="file" accept="image/*" ref="fileInput"
                                            @change="handleFileChange" />
                                    </div>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                    </CardContent>
                </Card> -->

                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Shield class="size-5" />
                            Rol y Permisos
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="role">
                                <FormItem v-auto-animate>
                                    <FormLabel>Rol *</FormLabel>
                                    <Select v-bind="componentField">
                                        <FormControl>
                                            <SelectTrigger>
                                                <SelectValue placeholder="Selecciona un rol" />
                                            </SelectTrigger>
                                        </FormControl>
                                        <SelectContent>
                                            <SelectItem v-for="(role, index) in roles" :key="index" :value="role.name">
                                                {{ role.name }}
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="department">
                                <FormItem v-auto-animate>
                                    <FormLabel>Departamento *</FormLabel>
                                    <Select v-bind="componentField">
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
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4">
            <Button type="button" variant="outline" @click="$router.back">
                Cancelar
            </Button>
            <Button :disabled="loading" type="submit" class="min-w-32">
                <Save class="mr-2 h-4 w-4" />
                Crear Usuario
            </Button>
        </div>
    </form>
</template>

<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod';
import { Eye, EyeOff, Save, Shield, User } from 'lucide-vue-next';
import { useForm } from 'vee-validate';
import { z } from 'zod';
import Avatar from '~/components/ui/avatar/Avatar.vue';
import AvatarFallback from '~/components/ui/avatar/AvatarFallback.vue';
import AvatarImage from '~/components/ui/avatar/AvatarImage.vue';
import Button from '~/components/ui/button/Button.vue';
import Card from '~/components/ui/card/Card.vue';
import CardContent from '~/components/ui/card/CardContent.vue';
import CardHeader from '~/components/ui/card/CardHeader.vue';
import CardTitle from '~/components/ui/card/CardTitle.vue';
import { FormField } from '~/components/ui/form';
import FormControl from '~/components/ui/form/FormControl.vue';
import FormItem from '~/components/ui/form/FormItem.vue';
import FormLabel from '~/components/ui/form/FormLabel.vue';
import FormMessage from '~/components/ui/form/FormMessage.vue';
import Input from '~/components/ui/input/Input.vue';
import Select from '~/components/ui/select/Select.vue';
import SelectContent from '~/components/ui/select/SelectContent.vue';
import SelectGroup from '~/components/ui/select/SelectGroup.vue';
import SelectItem from '~/components/ui/select/SelectItem.vue';
import SelectTrigger from '~/components/ui/select/SelectTrigger.vue';
import SelectValue from '~/components/ui/select/SelectValue.vue';
import Textarea from '~/components/ui/textarea/Textarea.vue';
import { getInitials } from '~/lib/utils';
import type { Role } from '~/modules/role/types/Role';

const showPassword: Ref<boolean> = ref(false)
const fileInput = ref<HTMLInputElement>()

const emit = defineEmits(['submit'])

const props = defineProps<{
    loading?: boolean,
    roles: Role[]
}>()

const previewUrl = ref<string | null>(null)
const selectedFile = ref<File | null>(null)

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
    password: z
        .string()
        .nonempty({ message: 'La contraseña es obligatoria' }),
    notes: z
        .string()
        .optional(),
    avatar_file: z
        .instanceof(File)
        .optional(),
    role: z
        .string()
        .optional(),
    department: z
        .string()
        .nonempty({ message: 'El departamento es obligatorio' })
}))


const { handleSubmit, setFieldValue, values } = useForm({
    validationSchema: formSchema,
    initialValues: {
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        password: '',
        notes: '',
        role: '',
        department: ''
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

const onSubmit = handleSubmit((values) => {
    const formData = {
        ...values,
        avatar_file: selectedFile.value
    }

    emit('submit', formData)
})
</script>

<style scoped></style>