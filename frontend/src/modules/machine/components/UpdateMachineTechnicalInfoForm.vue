<template>
    <form class="space-y-6">
        <div class="space-y-2">
            <FormField v-slot="{ value, handleChange }" name="maintenance_interval_days">
                <FormItem v-auto-animate>
                    <FormLabel>Intervalo de Mantenimiento</FormLabel>
                    <FormControl v-if="editMode">
                        <NumberField :default-value="0" :min="0" locale="es"
                            :format-options="{ style: 'unit', unit: 'day', unitDisplay: 'long' }" :model-value="value"
                            @update:model-value="handleChange">
                            <NumberFieldContent>
                                <NumberFieldDecrement />
                                <NumberFieldInput />
                                <NumberFieldIncrement />
                            </NumberFieldContent>
                        </NumberField>
                    </FormControl>

                    <p v-else class="text-sm">{{ machine.maintenance_interval_days ? `${machine.maintenance_interval_days} Días` : '---' }}</p>
                    <FormMessage />
                </FormItem>
            </FormField>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="space-y-2">
                <FormField v-slot="{ value, handleChange }" name="operating_temperature_min">
                    <FormItem v-auto-animate>
                        <FormLabel>Temp. Mín.</FormLabel>
                        <FormControl v-if="editMode">
                            <NumberField :default-value="0" locale="es"
                                :format-options="{ style: 'unit', unit: 'celsius', unitDisplay: 'narrow' }"
                                :model-value="value" @update:model-value="handleChange">
                                <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                </NumberFieldContent>
                            </NumberField>
                        </FormControl>

                        <p v-else class="text-sm">{{ machine.operating_temperature_min ? `${machine.operating_temperature_min} Cº` : '---' }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ value, handleChange }" name="operating_temperature_max">
                    <FormItem v-auto-animate>
                        <FormLabel>Temp. Máx.</FormLabel>
                        <FormControl v-if="editMode">
                            <NumberField :default-value="0" locale="es"
                                :format-options="{ style: 'unit', unit: 'celsius', unitDisplay: 'narrow' }"
                                :model-value="value" @update:model-value="handleChange">
                                <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                </NumberFieldContent>
                            </NumberField>
                        </FormControl>

                        <p v-else class="text-sm">{{ machine.operating_temperature_max ? `${machine.operating_temperature_max} Cº` : '---' }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ value, handleChange }" name="operating_pressure_max">
                    <FormItem v-auto-animate>
                        <FormLabel>Presión Máx. (bar)</FormLabel>
                        <FormControl v-if="editMode">
                            <NumberField :model-value="value" locale="es" :step="0.1"
                                :format-options="{ maximumFractionDigits: 1 }" @update:model-value="handleChange">
                                <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                </NumberFieldContent>
                            </NumberField>
                        </FormControl>

                        <p v-else class="text-sm">{{ machine.operating_pressure_max ? `${machine.operating_pressure_max} Bar` : '---' }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="space-y-2">
                <FormField v-slot="{ value, handleChange }" name="power_consumption">
                    <FormItem v-auto-animate>
                        <FormLabel>Consumo (kW)</FormLabel>
                        <FormControl v-if="editMode">
                            <NumberField locale="es" :step="0.1" :format-options="{ maximumFractionDigits: 1 }"
                                :model-value="value" @update:model-value="handleChange">
                                <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                </NumberFieldContent>
                            </NumberField>
                        </FormControl>

                        <p v-else class="text-sm">{{ machine.power_consumption ? `${machine.power_consumption} kW` : '---' }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ value, handleChange }" name="voltage">
                    <FormItem v-auto-animate>
                        <FormLabel>Voltaje (V)</FormLabel>
                        <FormControl v-if="editMode">
                            <NumberField :default-value="0" :model-value="value" @update:model-value="handleChange">
                                <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                </NumberFieldContent>
                            </NumberField>
                        </FormControl>

                        <p v-else class="text-sm">{{ machine.voltage ? `${machine.voltage} V` : '---' }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ value, handleChange }" name="frequency">
                    <FormItem v-auto-animate>
                        <FormLabel>Frecuencia (Hz)</FormLabel>
                        <FormControl v-if="editMode">
                            <NumberField :default-value="0" :model-value="value" @update:model-value="handleChange">
                                <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                </NumberFieldContent>
                            </NumberField>
                        </FormControl>

                        <p v-else class="text-sm">{{ machine.frequency ? `${machine.frequency} Hz` : '---' }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <FormField v-slot="{ value, handleChange }" name="weight">
                    <FormItem v-auto-animate>
                        <FormLabel>Peso</FormLabel>
                        <FormControl v-if="editMode">
                            <NumberField locale="es" :step="0.1"
                                :format-options="{ style: 'unit', unit: 'kilogram', unitDisplay: 'short' }"
                                :model-value="value" @update:model-value="handleChange">
                                <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                </NumberFieldContent>
                            </NumberField>
                        </FormControl>

                        <p v-else class="text-sm">{{ machine.weight ? `${machine.weight} Kg` : '---' }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>

            <div class="space-y-2">
                <FormField v-slot="{ componentField }" name="dimensions">
                    <FormItem v-auto-animate>
                        <FormLabel>Dimensiones (L x W x H)</FormLabel>
                        <FormControl v-if="editMode">
                            <Input type="text" placeholder="2.0 x 1.5 x 1.8 m" v-bind="componentField" />
                        </FormControl>

                        <p v-else class="text-sm">{{ machine.dimensions ?? '---' }}</p>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>
    </form>
</template>

<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod';
import type { MachineDetails } from '../types/MachineDetails';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import { FormField } from '~/components/ui/form';
import FormItem from '~/components/ui/form/FormItem.vue';
import FormLabel from '~/components/ui/form/FormLabel.vue';
import FormControl from '~/components/ui/form/FormControl.vue';
import NumberField from '~/components/ui/number-field/NumberField.vue';
import NumberFieldContent from '~/components/ui/number-field/NumberFieldContent.vue';
import NumberFieldDecrement from '~/components/ui/number-field/NumberFieldDecrement.vue';
import NumberFieldInput from '~/components/ui/number-field/NumberFieldInput.vue';
import NumberFieldIncrement from '~/components/ui/number-field/NumberFieldIncrement.vue';
import FormMessage from '~/components/ui/form/FormMessage.vue';
import Input from '~/components/ui/input/Input.vue';

const props = withDefaults(defineProps<{
    machine: MachineDetails
    editMode: boolean
}>(), {
    editMode: false
})

const formSchema = toTypedSchema(z.object({
    maintenance_interval_days: z
        .coerce
        .number()
        .optional(),
    operating_temperature_min: z
        .coerce
        .number()
        .optional(),
    operating_temperature_max: z
        .coerce
        .number()
        .optional(),
    operating_pressure_max: z
        .coerce
        .number()
        .optional(),
    power_consumption: z
        .coerce
        .number()
        .optional(),
    voltage: z
        .coerce
        .number()
        .optional(),
    frequency: z
        .coerce
        .number()
        .optional(),
    weight: z
        .coerce
        .number()
        .optional(),
    dimensions: z
        .string()
        .optional()
}))

const { handleSubmit, resetForm } = useForm({
    validationSchema: formSchema,
    initialValues: {
        maintenance_interval_days: props.machine.maintenance_interval_days ?? 0,
        operating_temperature_min: props.machine.operating_temperature_min ?? 0,
        operating_temperature_max: props.machine.operating_temperature_min ?? 0,
        operating_pressure_max: props.machine.operating_pressure_max ?? 0,
        power_consumption: props.machine.power_consumption ?? 0,
        voltage: props.machine.voltage ?? 0,
        frequency: props.machine.frequency ?? 0,
        weight: props.machine.weight ?? 0,
        dimensions: props.machine.dimensions ?? '',
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