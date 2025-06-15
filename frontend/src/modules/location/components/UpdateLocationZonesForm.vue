<template>
    <form class="space-y-6">
        <div class="space-y-4">
            <Label>Zonas Internas</Label>
            <div v-if="editMode" class="flex gap-2 mt-2">
                <Input type="text" v-model="newZone" @keypress.enter.prevent="handleAddZone" class="flex-1" />
                <Button type="button" @click="handleAddZone">
                    <Plus class="size-4" />
                </Button>
            </div>
            <div class="flex flex-wrap gap-2 mt-3">
                <Badge v-for="(zone, index) in values.zones" :key="index" class="flex items-center gap-2"
                    variant="secondary">
                    {{ zone }}
                    <Button v-if="editMode" type="button" variant="ghost" :size="null"
                        class="h-auto p-1 text-muted-foreground hover:text-destructive"
                        @click="setFieldValue('zones', (values.zones ?? []).filter(z => z !== zone));">
                        <X class="size-3" />
                    </Button>
                </Badge>
                
                <p v-if="location.zones?.length === 0 && !editMode" class="text-sm">---</p>
            </div>
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
import { Plus, X } from 'lucide-vue-next';
import Button from '~/components/ui/button/Button.vue';
import Input from '~/components/ui/input/Input.vue';

const props = withDefaults(defineProps<{
    location: LocationDetails,
    editMode: boolean
}>(), {
    editMode: false
})

const newZone: Ref<string> = ref('')

const handleAddZone = () => {
    const zone = newZone.value.trim();
    const zones = values.zones ?? [];

    if (zone && !zones.some(z => z.toLowerCase() === zone.toLowerCase())) {
        setFieldValue('zones', [...zones, zone]);
        newZone.value = '';
    }
}

const formSchema = toTypedSchema(z.object({
    zones: z
        .array(z.string())
        .optional(),

}))

const { handleSubmit, resetForm, setFieldValue, values } = useForm({
    validationSchema: formSchema,
    initialValues: {
        zones: props.location.zones?.map((zone) => zone.name),
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