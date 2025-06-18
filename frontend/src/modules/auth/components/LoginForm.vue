<template>
    <form @submit="onSubmit" class="w-full space-y-6">
        <FormField v-slot="{ componentField }" name="email" :validate-on-blur="!isFieldDirty">
            <FormItem v-auto-animate>
                <FormLabel>Correo Electrónico</FormLabel>
                <FormControl>
                    <Input type="email" placeholder="example@hotmail.com" v-bind="componentField" />
                </FormControl>
                <FormDescription>Introduce tu correo electrónico</FormDescription>
                <FormMessage />
            </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="password" :validate-on-blur="!isFieldDirty">
            <FormItem v-auto-animate>
                <FormLabel>Contraseña</FormLabel>
                <FormControl>
                    <div class="relative items-center">
                        <Input :type="showPassword ? 'text' : 'password'" placeholder="Contraseña"
                            v-bind="componentField" />

                        <Button type="button" variant="ghost" class="absolute end-0 inset-y-0 flex items-center justify-center px-2"
                            @click.prevent="showPassword = !showPassword">
                            <component :is="showPassword ? EyeOff : Eye" class="size-4 text-muted-foreground" />
                        </Button>
                    </div>
                </FormControl>
                <FormDescription>Introduce tu contraseña</FormDescription>
                <FormMessage />
            </FormItem>
        </FormField>

        <Button :disabled="loading" type="submit" size="lg"
            class="w-full uppercase tracking-wide font-semibold active:bg-slate-600">
            <Loader2 v-if="loading" class="w-4 h-4 mr-2 animate-spin" />
            Iniciar Sesión
            <LogIn v-if="!loading" class="w-4 h-4 ml-2" />
        </Button>
    </form>
</template>

<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import { vAutoAnimate } from '@formkit/auto-animate/vue'
import * as z from 'zod'

import {
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from '@/components/ui/form'

import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Eye, EyeOff, Loader2, LogIn } from 'lucide-vue-next'

const emit = defineEmits(['submit'])

const props = defineProps({
    'loading': {
        type: Boolean,
        default: false
    }
})

const showPassword: Ref<boolean> = ref(false)

const formSchema = toTypedSchema(z.object({
    email: z
        .string()
        .nonempty({ message: 'El email es obligatorio' })
        .email({ message: 'El email no es válido' }),
    password: z
        .string()
        .nonempty({ message: 'El contraseña es obligatoria' })
        .min(8, { message: 'La contraseña debe tener al menos 8 caracteres' })
        .regex(/[A-Z]/, { message: 'La contraseña debe contener al menos una letra mayúscula' })
        .regex(/[!@#$%^&*(),.?":{}|<>]/, { message: 'La contraseña debe contener al menos un carácter especial' })
}))

const { isFieldDirty, handleSubmit } = useForm({
    validationSchema: formSchema,
})

const onSubmit = handleSubmit((values) => {
    emit('submit', values)
})
</script>

<style scoped></style>