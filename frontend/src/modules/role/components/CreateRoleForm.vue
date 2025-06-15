<template>
    <form @submit="onSubmit" class="space-y-6">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Shield class="size-5" />
                            Información del Rol
                        </CardTitle>
                        <CardDescription>Configuración básica del rol</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="name">
                                <FormItem v-auto-animate>
                                    <FormLabel>Nombre de Rol *</FormLabel>
                                    <FormControl>
                                        <Input type="text" placeholder="Administrator" v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="description">
                                <FormItem v-auto-animate>
                                    <FormLabel>Descripción *</FormLabel>
                                    <FormControl>
                                        <Textarea placeholder="Describe las responsabilidades y alcance de este rol..."
                                            v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="color">
                                <FormItem v-auto-animate>
                                    <FormLabel>Color del Rol</FormLabel>
                                    <Select v-bind="componentField">
                                        <FormControl>
                                            <SelectTrigger>
                                                <SelectValue placeholder="Selecciona un color">
                                                    <div class="flex items-center gap-2">
                                                        <div v-if="componentField.modelValue" class="size-4 rounded"
                                                            :class="colors.find(c => c.id === componentField.modelValue)?.class" />
                                                        {{colors.find(c => c.id === componentField.modelValue)?.name ||
                                                            'Selecciona un color'}}
                                                    </div>
                                                </SelectValue>
                                            </SelectTrigger>
                                        </FormControl>
                                        <SelectContent>
                                            <SelectItem v-for="(color) in colors" :key="color.id" :value="color.id">
                                                <div class="flex items-center gap-2">
                                                    <div class="size-4 rounded" :class="color.class" />
                                                    {{ color.name }}
                                                </div>
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div v-if="values.color && values.name" class="p-4 bg-muted rounded-lg">
                            <h4 class="font-medium mb-2">Vista previa:</h4>
                            <Badge :class="colors.find((c) => c.id === values.color)?.class">
                                <Shield class="mr-1 h-3 w-3" />
                                {{ values.name }}
                            </Badge>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <div>
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Users class="h-5 w-5" />
                            Plantillas
                        </CardTitle>
                        <CardDescription>Usar plantilla predefinida</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <div v-for="(template) in roleTemplates" :key="template.id"
                            class="p-3 border rounded-lg cursor-pointer hover:bg-muted transition-colors" @click="handleTemplateSelect(template.id)">
                            <h4 class="font-medium">{{ template.name }}</h4>
                            <p class="text-sm text-muted-foreground">{{ template.description }}</p>
                            <p class="text-xs text-muted-foreground mt-1">{{ template.permissions.length }} permisos</p>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>

        <Card>
            <CardHeader>
                <CardTitle class="flex items-center gap-2">
                    <Key class="size-5" />
                    Permisos del Rol
                </CardTitle>
                <CardDescription>
                    Selecciona los permisos que tendrá este rol
                    <span v-if="values.permissions">({{ values.permissions?.length }}) permisos seleccionados</span>
                    <p v-if="errors.permissions" class="text-sm text-red-500 mt-1">{{ errors.permissions }}</p>
                </CardDescription>
            </CardHeader>
            <CardContent>
                <div v-for="(category, categoryKey) in PERMISSION_CATEGORIES" :key="categoryKey" class="space-y-3 mb-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <Checkbox :id="`category-${categoryKey}`"
                                :model-value="someSelected(category) && !allSelected(category) ? 'indeterminate' : allSelected(category)"
                                @update:model-value="(checked) => toggleCategory(category, !!checked)" />
                            <Label :for="`category-${categoryKey}`">
                                {{ category.name }}
                            </Label>
                            <Badge v-if="someSelected(category)" variant="secondary" class="text-xs">
                                {{ selectedInCategory(category).length }}/{{ getCategoryPermissionIds(category).length
                                }}
                            </Badge>
                        </div>
                    </div>

                    <FormField name="permissions">
                        <FormItem v-auto-animate>
                            <FormControl>
                                <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-3 ml-6">
                                    <FormField class="space-y-1" v-for="permission in category.permissions"
                                        v-slot="{ value, handleChange }" :key="permission.id" type="checkbox"
                                        :value="permission.id" :unchecked-value="false" name="permissions">
                                        <div class="flex flex-col gap-2">
                                            <div class="flex items-center space-x-2 ">
                                                <Checkbox :id="permission.id"
                                                    :model-value="value.includes(permission.id)"
                                                    @update:model-value="handleChange" />
                                                <FormLabel :for="permission.id">
                                                    {{ permission.name }}
                                                </FormLabel>
                                            </div>
                                            <p class="text-xs text-muted-foreground ml-6">{{ permission.description }}
                                            </p>
                                        </div>
                                    </FormField>
                                </div>
                            </FormControl>
                        </FormItem>
                    </FormField>
                </div>
            </CardContent>
        </Card>

        <div class="flex items-center justify-end gap-4">
            <Button type="button" variant="outline" @click="$router.back">
                Cancelar
            </Button>
            <Button type="submit" class="min-w-32">
                <Save v-if="!loading" class="mr-2 size-4" />
                <Loader2 v-else class="mr-2 size-4 animate-spin" />
                Crear Rol
            </Button>
        </div>
    </form>
</template>

<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod';
import { Key, Loader2, Save, Shield, Users } from 'lucide-vue-next';
import { useForm } from 'vee-validate';
import { z } from 'zod';
import Badge from '~/components/ui/badge/Badge.vue';
import Button from '~/components/ui/button/Button.vue';
import Card from '~/components/ui/card/Card.vue';
import CardContent from '~/components/ui/card/CardContent.vue';
import CardDescription from '~/components/ui/card/CardDescription.vue';
import CardHeader from '~/components/ui/card/CardHeader.vue';
import CardTitle from '~/components/ui/card/CardTitle.vue';
import Checkbox from '~/components/ui/checkbox/Checkbox.vue';
import { FormField } from '~/components/ui/form';
import FormControl from '~/components/ui/form/FormControl.vue';
import FormItem from '~/components/ui/form/FormItem.vue';
import FormLabel from '~/components/ui/form/FormLabel.vue';
import FormMessage from '~/components/ui/form/FormMessage.vue';
import Input from '~/components/ui/input/Input.vue';
import Label from '~/components/ui/label/Label.vue';
import Select from '~/components/ui/select/Select.vue';
import SelectContent from '~/components/ui/select/SelectContent.vue';
import SelectItem from '~/components/ui/select/SelectItem.vue';
import SelectTrigger from '~/components/ui/select/SelectTrigger.vue';
import SelectValue from '~/components/ui/select/SelectValue.vue';
import Textarea from '~/components/ui/textarea/Textarea.vue';
import { PERMISSION_CATEGORIES } from '~/modules/shared/constants/permissions';
import { roleTemplates } from '~/modules/shared/constants/roleTemplates';

const emit = defineEmits(['submit'])

const props = defineProps<{
    loading?: boolean
}>()

const colors = [
    { id: "blue", name: "Azul", class: "bg-blue-100 text-blue-800" },
    { id: "green", name: "Verde", class: "bg-green-100 text-green-800" },
    { id: "purple", name: "Morado", class: "bg-purple-100 text-purple-800" },
    { id: "orange", name: "Naranja", class: "bg-orange-100 text-orange-800" },
    { id: "red", name: "Rojo", class: "bg-red-100 text-red-800" },
    { id: "gray", name: "Gris", class: "bg-gray-100 text-gray-800" },
]

const getCategoryPermissionIds = (category: any): string[] => {
    return category.permissions.map(p => p.id);
};

const selectedInCategory = (category: any) => {
    return values.permissions?.filter(p => getCategoryPermissionIds(category).includes(p)) ?? []
}
const allSelected = (category): boolean => {
    return selectedInCategory(category).length === getCategoryPermissionIds(category).length
}

const someSelected = (category): boolean => {
    return selectedInCategory(category).length > 0
}

const formSchema = toTypedSchema(z.object({
    name: z
        .string()
        .nonempty({ message: 'El nombre es obligatorio' }),
    description: z
        .string()
        .nonempty({ message: 'La descripción ses obligatoria' }),
    color: z
        .string()
        .optional(),
    permissions: z.array(z.string()).refine(value => value.length > 0, {
        message: 'Debes seleccionar al menos un permiso.',
    }),
}))


const { handleSubmit, setFieldValue, setValues, values, errors } = useForm({
    validationSchema: formSchema,
    initialValues: {
        name: '',
        description: '',
        color: '',
        permissions: []
    }
})

const toggleCategory = (category: any, checked: boolean) => {
    const categoryPermissionIds = getCategoryPermissionIds(category);

    if (checked) {
        const currentPermissions = values.permissions || [];
        const newPermissions = [...currentPermissions];

        categoryPermissionIds.forEach(permissionId => {
            if (!newPermissions.includes(permissionId)) {
                newPermissions.push(permissionId);
            }
        });

        setFieldValue('permissions', newPermissions);
    } else {
        const currentPermissions = values.permissions || [];
        const newPermissions = currentPermissions.filter(
            permissionId => !categoryPermissionIds.includes(permissionId)
        );

        setFieldValue('permissions', newPermissions);
    }
};

const handleTemplateSelect = (templateId: string) => {
    const template = roleTemplates.find((t) => t.id === templateId)

    if (template) {
        setValues({
            name: template.name,
            description: template.description,
            permissions: [...template.permissions],
        })
    }
}

const onSubmit = handleSubmit((values) => {
    emit('submit', values)
})

</script>

<style scoped></style>