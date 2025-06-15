<template>
    <form class="space-y-6">
        <div class="flex flex-col items-center text-center space-y-4">
            <div class="p-4 bg-blue-100 rounded-lg">
                <Cpu class="size-8 text-blue-600" />
            </div>
            <div>
                <h3 class="font-semibold text-lg">{{ machine.name }}</h3>
                <p class="text-muted-foreground">{{ machine.type.name }}</p>
            </div>

            <div class="space-y-2 w-1/2">
                <FormField v-slot="{ componentField }" name="status">
                    <FormItem v-auto-animate>
                        <Select v-if="editMode" v-bind="componentField">
                            <FormControl>
                                <SelectTrigger>
                                    <SelectValue placeholder="Seleccionar estado" />
                                </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem v-for="(state, index) in states" :key="index" :value="state.value">
                                        {{ state.label }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>

                        <Badge v-else :class="`${getStatusMeta(machine.status).color} border mx-auto`">
                            <component :is="getStatusMeta(machine.status).icon" />
                            <span class="ml-1">{{ getStatusMeta(machine.status).label }}</span>
                        </Badge>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>
    </form>
</template>

<script setup lang="ts">
import Badge from '~/components/ui/badge/Badge.vue';
import type { MachineDetails } from '../types/MachineDetails';
import { Cpu } from 'lucide-vue-next';
import { getStatusMeta } from '../utils/getStatusMeta';
import { FormField } from '~/components/ui/form';
import FormItem from '~/components/ui/form/FormItem.vue';
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
    machine: MachineDetails
    editMode: boolean
}>(), {
    editMode: false
})

const states: Ref<{ label: string, value: string }[]> = ref([
    { label: 'Operativo', value: 'operational' },
    { label: 'Mantenimiento', value: 'maintenance' },
    { label: 'Advertencia', value: 'warning' },
    { label: 'Critico', value: 'critical' },
    { label: 'Retirado', value: 'retired' },
])

const formSchema = toTypedSchema(z.object({
    status: z
        .string()
        .nonempty({ message: 'El estado es obligatorio' })
}))

const { handleSubmit, resetForm} = useForm({
    validationSchema: formSchema,
    initialValues: {
        status: props.machine.status,
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