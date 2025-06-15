<template>
    <PopoverComponent>
        <form @submit="onSubmit" class="space-y-6">
            <div class="p-2">
                <h3 class="text-md font-semibold mb-3">Creación de Tipo de Máquina</h3>
                <div class="space-y-2">
                    <FormField v-slot="{ componentField }" name="name">
                        <FormItem>
                            <FormLabel>Nombre *</FormLabel>
                            <FormControl>
                                <Input type="text" placeholder="Bomba" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                </div>

                <div class="flex items-center justify-end gap-4 mt-5">
                    <Button type="submit" class="w-full">
                        <Save class="mr-2 size-4" />
                        Crear tipo
                    </Button>
                </div>
            </div>
        </form>
    </PopoverComponent>

</template>

<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod';
import { Save } from 'lucide-vue-next';
import { useForm } from 'vee-validate';
import { z } from 'zod';
import PopoverComponent from '~/components/custom/Popover/PopoverComponent.vue';
import Button from '~/components/ui/button/Button.vue';
import { FormField } from '~/components/ui/form';
import FormControl from '~/components/ui/form/FormControl.vue';
import FormItem from '~/components/ui/form/FormItem.vue';
import FormLabel from '~/components/ui/form/FormLabel.vue';
import FormMessage from '~/components/ui/form/FormMessage.vue';
import Input from '~/components/ui/input/Input.vue';
import { useCreateMachineType } from '../composables/type/useCreateMachineType';

const formSchema = toTypedSchema(z.object({
    name: z
        .string()
        .nonempty({ message: 'El tipo es obligatorio' }),
}))

const { handleSubmit, resetForm } = useForm({
    validationSchema: formSchema,
    initialValues: {
        name: ''
    }
})

const { mutate: create } = useCreateMachineType()

const onSubmit = handleSubmit((values) => {
    create(values, {
        onSuccess: () => {
            resetForm()
        }
    })
})

</script>

<style scoped></style>