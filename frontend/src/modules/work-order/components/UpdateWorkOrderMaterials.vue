<template>
    <div v-if="editMode" class="flex gap-2">
        <Input type="text" placeholder="Nombre del material" v-model="newMaterial.material_name"
            @keypress.enter.prevent="handleAddMaterial" class="flex-1" />
        <NumberField :default-value="1" :min="1" locale="es" :model-value="newMaterial.quantity"
            @update:model-value="newMaterial.quantity = $event" class="w-24">
            <NumberFieldContent>
                <NumberFieldDecrement />
                <NumberFieldInput />
                <NumberFieldIncrement />
            </NumberFieldContent>
        </NumberField>

        <Select v-model="newMaterial.unit">
            <SelectTrigger>
                <SelectValue placeholder="Unidad" />
            </SelectTrigger>
            <SelectContent>
                <SelectGroup>
                    <SelectItem value="unit">Unidad</SelectItem>
                    <SelectItem value="meter">Metro</SelectItem>
                    <SelectItem value="liter">Litro</SelectItem>
                    <SelectItem value="kg">Kg</SelectItem>
                    <SelectItem value="box">Caja</SelectItem>
                </SelectGroup>
            </SelectContent>
        </Select>

        <Button type="button" @click="handleAddMaterial">
            <Plus class="size-4" />
        </Button>
    </div>

    <div class="space-y-2">
        <div v-if="values.materials?.length !== 0" v-for="(material, index) in values.materials" :key="index"
            class="flex items-center justify-between p-2 bg-muted rounded-lg">
            <span class="text-sm">
                {{ material.material_name }} - {{ material.quantity }} {{ getUnitText(material.unit)
                }}
            </span>
            <Button v-if="editMode" type="button" variant="ghost" size="sm"
                @click="setFieldValue('materials', (values.materials ?? []).filter(m => m.material_name !== material.material_name))">
                <X class="size-4" />
            </Button>
        </div>

        <p v-else class="text-sm">---</p>
    </div>
</template>

<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod';
import type { WorkOrderDetails } from '../types/WorkOrderDetails';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import Input from '~/components/ui/input/Input.vue';
import NumberField from '~/components/ui/number-field/NumberField.vue';
import NumberFieldContent from '~/components/ui/number-field/NumberFieldContent.vue';
import NumberFieldDecrement from '~/components/ui/number-field/NumberFieldDecrement.vue';
import NumberFieldInput from '~/components/ui/number-field/NumberFieldInput.vue';
import SelectTrigger from '~/components/ui/select/SelectTrigger.vue';
import SelectValue from '~/components/ui/select/SelectValue.vue';
import NumberFieldIncrement from '~/components/ui/number-field/NumberFieldIncrement.vue';
import SelectContent from '~/components/ui/select/SelectContent.vue';
import SelectGroup from '~/components/ui/select/SelectGroup.vue';
import SelectItem from '~/components/ui/select/SelectItem.vue';
import Button from '~/components/ui/button/Button.vue';
import { Plus, X } from 'lucide-vue-next';
import type { CreateWorkOrderMaterialPayload } from '../types/CreateWorkOrderMaterialPayload';
import Select from '~/components/ui/select/Select.vue';

const props = withDefaults(defineProps<{
    workOrder: WorkOrderDetails
    editMode: boolean
}>(), {
    editMode: false
})

const newMaterial: Ref<CreateWorkOrderMaterialPayload> = ref({
    material_name: '',
    quantity: 1,
    unit: 'unit'
})

const handleAddMaterial = () => {
    const { material_name, quantity, unit } = newMaterial.value
    const name = material_name.trim()
    const materials = values.materials ?? []

    if (
        name &&
        quantity > 0 &&
        unit &&
        !materials.some(m =>
            m.material_name.toLowerCase() === name.toLowerCase() && m.unit === unit
        )
    ) {
        setFieldValue('materials', [...materials, { material_name: name, quantity, unit }])
        newMaterial.value = { material_name: '', quantity: 1, unit: 'unit' }
    }
}

const getUnitText = (unit: string): string => {
    switch (unit) {
        case 'unit':
            return '(Unidad)'
        case 'kg':
            return '(Kg)'
        case 'meter':
            return '(Metro)'
        case 'liter':
            return '(Litro)'
        case 'box':
            return '(Caja)'
        default:
            return unit
    }
}

const formSchema = toTypedSchema(z.object({
    materials: z.array(
        z.object({
            material_name: z.string(),
            quantity: z.coerce.number(),
            unit: z.string()
        })
    ),
}))

const { handleSubmit, setFieldValue, values, resetForm } = useForm({
    validationSchema: formSchema,
    initialValues: {
        materials: props.workOrder.materials
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