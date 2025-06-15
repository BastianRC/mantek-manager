<template>
    <form class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2">
            <FormField name="systems">
                <FormItem v-auto-animate>
                    <FormControl>
                        <Label>Sistemas Instalados</Label>
                        <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-3" :class="{ 'mt-3': editMode }">
                            <FormField v-for="(system) in systems ?? []" :key="system.value" name="systems"
                                type="checkbox" :value="system.value" :unchecked-value="false"
                                v-slot="{ value, handleChange }">
                                <div v-if="editMode" class="flex items-center space-x-2">
                                    <Checkbox :id="system.value" :model-value="(value).includes(system.value)"
                                        @update:model-value="handleChange" />
                                    <FormLabel :for="system.value">
                                        {{ system.label }}
                                    </FormLabel>
                                </div>
                            </FormField>
                        </div>

                        <div v-if="values.systems && editMode" class="flex flex-wrap gap-2 mt-3">
                            <Badge v-for="(system) in values.systems" :key="system" variant="outline">
                                {{systems.find((val) => val.value === system)?.label}}
                            </Badge>
                        </div>
                    </FormControl>

                    <div v-if="!editMode" class="flex flex-wrap gap-2">
                        <Badge v-for="(system) in location.systems" :key="system.id" variant="outline">
                            {{  systems.find((val) => val.value === system.type)?.label }}
                        </Badge>

                        <p v-if="location.systems?.length === 0" class="text-sm">---</p>
                    </div>
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
import type { LocationDetails } from '../types/LocationDetails';
import type { LocationSystemOptions } from '../types/LocationSystemOptions';
import Label from '~/components/ui/label/Label.vue';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import Checkbox from '~/components/ui/checkbox/Checkbox.vue';
import Badge from '~/components/ui/badge/Badge.vue';

const props = withDefaults(defineProps<{
    location: LocationDetails,
    systems: LocationSystemOptions[],
    editMode: boolean
}>(), {
    editMode: false
})

const formSchema = toTypedSchema(z.object({
    systems: z
        .array(z.string())
        .optional(),

}))

const { handleSubmit, resetForm, values } = useForm({
    validationSchema: formSchema,
    initialValues: {
        systems: props.location.systems?.map((system) => system.type),
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