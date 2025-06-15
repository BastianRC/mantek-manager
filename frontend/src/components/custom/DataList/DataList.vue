<template>
    <Card class="mb-6">
        <CardHeader>
            <CardTitle class="text-xl font-bold">Filtros</CardTitle>
        </CardHeader>
        <CardContent>
            <div class="flex flex-col gap-4 lg:flex-row">
                <div class="flex-1">
                    <div class="relative">
                        <Search class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                        <Input class="pl-10" placeholder="Buscar..." v-model="searchTerm" />
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4">
                    <Select v-for="filter in props.filters" :key="filter.key" v-model="filterValues[filter.key]">
                        <SelectTrigger class="w-full lg:w-42">
                            <SelectValue :placeholder="filter.label" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">Todos</SelectItem>
                            <SelectItem v-for="opt in getFilterOptions(filter)" :key="opt.value" :value="opt.value">
                                {{ opt.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>

                    <Select v-model="itemsPerPage">
                        <SelectTrigger class="w-full lg:w-40">
                            <SelectValue placeholder="Paginación" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="size in props.itemsPerPageOptions ?? [10, 20, 50]" :key="size"
                                :value="size">
                                {{ size }} por página
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </div>
        </CardContent>
    </Card>

    <Card>
        <CardHeader>
            <CardTitle class="text-xl font-bold">{{ title }}</CardTitle>
            <CardDescription>
                Mostrando {{ startIndex + 1 }}-{{ Math.min(endIndex, filteredItems.length) }} de {{
                    filteredItems.length }} resultados
            </CardDescription>
        </CardHeader>
        <CardContent>
            <div :class="props.gridClass ?? 'grid gap-4 lg:grid-cols-2 xl:grid-cols-3'">
                <slot name="item" :item="paginatedItems" />
            </div>

            <div v-if="totalPages > 1" class="mt-6 flex items-center justify-between border-t pt-4">
                <div class="text-sm text-muted-foreground">
                    Página {{ currentPage }} de {{ totalPages }}
                </div>
                <div class="flex items-center gap-2">
                    <Pagination :items-per-page="itemsPerPage" :total="filteredItems.length" :default-page="1">
                    <PaginationContent v-slot="{ items }">
                        <PaginationPrevious @click="currentPage = Math.max(1, currentPage - 1)" />
                        <template v-for="(item, index) in items" :key="index">
                            <PaginationItem v-if="item.type === 'page'" :value="item.value"
                                :is-active="item.value === currentPage" @click="currentPage = item.value">
                                {{ item.value }}
                            </PaginationItem>
                        </template>
                        <PaginationNext @click="currentPage = Math.min(totalPages, currentPage + 1)" />
                    </PaginationContent>
                </Pagination>
                </div>
            </div>
        </CardContent>
    </Card>
</template>


<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import Card from '@/components/ui/card/Card.vue'
import CardHeader from '@/components/ui/card/CardHeader.vue'
import CardTitle from '@/components/ui/card/CardTitle.vue'
import CardDescription from '@/components/ui/card/CardDescription.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import Input from '@/components/ui/input/Input.vue'
import Select from '@/components/ui/select/Select.vue'
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue'
import SelectValue from '@/components/ui/select/SelectValue.vue'
import SelectContent from '@/components/ui/select/SelectContent.vue'
import SelectItem from '@/components/ui/select/SelectItem.vue'
import Pagination from '@/components/ui/pagination/Pagination.vue'
import PaginationContent from '@/components/ui/pagination/PaginationContent.vue'
import PaginationPrevious from '@/components/ui/pagination/PaginationPrevious.vue'
import PaginationItem from '@/components/ui/pagination/PaginationItem.vue'
import PaginationNext from '@/components/ui/pagination/PaginationNext.vue'
import { Search } from 'lucide-vue-next'
import type { FilterDefinition } from './types'
import { getNestedValue } from './utils'
import type { FilterCardProps } from './types'

const props = defineProps<FilterCardProps>()
const emit = defineEmits<{ (e: 'filtered', value: any[]): void }>()

const searchTerm = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(props.itemsPerPageOptions?.[0] ?? 10)
const filterValues = ref<Record<string, string>>({})

watch(() => props.filters, (filters) => {
    filters?.forEach(f => {
        if (!(f.key in filterValues.value)) filterValues.value[f.key] = 'all'
    })
}, { immediate: true })

const getFilterOptions = (filter: FilterDefinition) => {
    if (filter.options) return filter.options
    if (!filter.dynamic || !filter.key) return []
    const values = [...new Set(props.items.map(i => getNestedValue(i, filter.key)))]
    return values.map(v => ({ value: v, label: v }))
}

const filteredItems = computed(() => {
    return props.items.filter(item => {
        const search = searchTerm.value.toLowerCase()
        const matchesSearch = props.searchKeys.some(key =>
            getNestedValue(item, key).toLowerCase().includes(search)
        )

        const matchesFilters = props.filters?.every(filter => {
            const selected = filterValues.value[filter.key]
            if (!selected || selected === 'all') return true
            const value = getNestedValue(item, filter.key)

            if (filter.type === 'boolean') {
                return Boolean(value) === (selected === 'true')
            }

            return value === selected
        }) ?? true

        return matchesSearch && matchesFilters
    })
})

watch(filteredItems, v => {
    currentPage.value = 1
    emit('filtered', v)
}, { immediate: true })

const totalPages = computed(() =>
    Math.ceil(filteredItems.value.length / itemsPerPage.value)
)

const startIndex = computed(() =>
    (currentPage.value - 1) * itemsPerPage.value
)

const endIndex = computed(() => startIndex.value + itemsPerPage.value)

const paginatedItems = computed(() =>
    filteredItems.value.slice(startIndex.value, endIndex.value)
)
</script>
