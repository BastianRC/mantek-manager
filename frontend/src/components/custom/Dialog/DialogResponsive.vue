<template>
    <UseTemplate>
        <div class="px-4 md:p-2 overflow-auto">
            <slot />
        </div>
    </UseTemplate>

    <Dialog v-if="isDesktop" v-model:open="isOpen">
        <DialogContent :class="cn('sm:max-w-[425px]', props.class)">
            <DialogHeader>
                <DialogTitle>{{ title }}</DialogTitle>
                <DialogDescription v-show="description">
                    {{ description }}.
                </DialogDescription>
            </DialogHeader>
            <GridForm />
        </DialogContent>
    </Dialog>

    <Drawer v-else v-model:open="isOpen">
        <DrawerContent>
            <DrawerHeader class="text-left">
                <DrawerTitle>{{ title }}</DrawerTitle>
                <DrawerDescription v-show="description">
                    {{ description }}
                </DrawerDescription>
            </DrawerHeader>
            <GridForm />
            <DrawerFooter class="pt-10">
            </DrawerFooter>
        </DrawerContent>
    </Drawer>
</template>

<script setup lang="ts">

import { Button } from '@/components/ui/button'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog'
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
} from '@/components/ui/drawer'
import { createReusableTemplate, useMediaQuery } from '@vueuse/core'
import { ref } from 'vue'
import { cn } from '~/lib/utils'

const [UseTemplate, GridForm] = createReusableTemplate()
const isDesktop = useMediaQuery('(min-width: 768px)', { ssrWidth: 768 })

const props = defineProps<{
    open: boolean,
    title: string,
    description?: string,
    class?: string
}>()
const emit = defineEmits<{ (e: 'update:open', value: boolean): void }>()

const isOpen: Ref<boolean> = ref(props.open)

watch(() => props.open, val => isOpen.value = val)
watch(isOpen, val => emit('update:open', val))

</script>