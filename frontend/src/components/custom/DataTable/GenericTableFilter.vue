<template>
    <Popover>
        <PopoverTrigger as-child>
            <slot />
        </PopoverTrigger>
        <PopoverContent>
            <div class="grid gap-4">
                <div class="grid gap-2">
                    <div class="grid grid-cols-1 items-center gap-4">
                        <Button variant="secondary"
                            class="w-full tracking-wide font-semibold hover:bg-slate-300 active:bg-slate-200"
                            @click="onToggleSort?.()" @dblclick="onUpdateSortState?.(undefined)">
                            <component :is="sortIcon" class="size-4" />
                            Ordenar
                        </Button>
                    </div>
                    <div class="grid grid-cols-1 items-center gap-4">
                        <Button variant="secondary"
                            class="w-full tracking-wide font-semibold hover:bg-slate-300 active:bg-slate-200"
                            @click="clearFilters">
                            <FunnelX />
                            Borrar Filtro
                        </Button>
                    </div>
                    <div class="grid grid-cols-1 items-center gap-4">
                        <Combobox v-model="selected" by="label" multiple>
                            <ComboboxAnchor as-child>
                                <ComboboxTrigger as-child class="w-full">
                                    <Button variant="outline" class="justify-between">
                                        <span v-if="selected?.length === 0 || selected === undefined">Selecciona un
                                            elemento</span>
                                        <span v-else class="overflow-hidden">{{selected.map(f => f.label).join(', ')
                                            }}</span>
                                        <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                    </Button>
                                </ComboboxTrigger>
                            </ComboboxAnchor>

                            <ComboboxList class="w-full">
                                <div class="relative w-full max-w-sm items-center">
                                    <ComboboxInput class="focus-visible:ring-0 border-0 border-b rounded-none h-10"
                                        placeholder="Buscar..." />
                                    <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
                                        <Search class="size-4 text-muted-foreground" />
                                    </span>
                                </div>

                                <ComboboxEmpty>
                                    No options found.
                                </ComboboxEmpty>

                                <ComboboxGroup>
                                    <ComboboxItem v-for="option in elements" :key="option.value" :value="option">
                                        {{ option.label }}
                                        <ComboboxItemIndicator>
                                            <Check class="ml-auto h-4 w-4" />
                                        </ComboboxItemIndicator>
                                    </ComboboxItem>
                                </ComboboxGroup>
                            </ComboboxList>
                        </Combobox>
                    </div>
                </div>
            </div>
        </PopoverContent>
    </Popover>
</template>

<script setup lang="ts">
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover';
import {
    Combobox,
    ComboboxAnchor,
    ComboboxEmpty,
    ComboboxGroup,
    ComboboxInput,
    ComboboxItem,
    ComboboxItemIndicator,
    ComboboxList,
    ComboboxTrigger
} from '@/components/ui/combobox'

import Button from '~/components/ui/button/Button.vue'
import { ArrowDown, ArrowUp, Check, ChevronsUpDown, FunnelX, Search } from 'lucide-vue-next'

const props = defineProps<{
    elements: { label: string, value: string }[]
    modelValue: string[] | string
    'onUpdate:modelValue': (value: string[] | undefined) => void
    sortState?: 'asc' | 'desc' | false
    onToggleSort?: () => void
    onUpdateSortState?: (state: 'asc' | 'desc' | undefined) => void
}>()

const selected = computed({
    get: () => props.elements.filter(opt => props.modelValue.includes(opt.value)),
    set: (selectedOptions) => {
        if (selectedOptions.length === 0) {
            props['onUpdate:modelValue'](undefined)
        } else {
            props['onUpdate:modelValue'](selectedOptions.map(opt => opt.value))
        }
    }
})

const clearFilters = () => {
    props['onUpdate:modelValue'](undefined)
}

const sortIcon = computed(() => {
    if (props.sortState === 'asc') return ArrowUp
    if (props.sortState === 'desc') return ArrowDown
    return ChevronsUpDown
})
</script>

<style scoped></style>
