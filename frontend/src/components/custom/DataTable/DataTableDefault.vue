<template>
    <div class="flex flex-row-reverse md:flex-row items-center justify-between py-4 gap-5">
        <div class="flex items-center gap-2">
            <Button v-if="canCreate" class="gap-2" @click="emits('create')">
                <CirclePlus />
                <span class="hidden md:block">Nuevo</span>
            </Button>
            <Button class="gap-2" @click="emits('refresh')">
                <RefreshCw />
                <span class="hidden md:block">Actualizar</span>
            </Button>
        </div>
        <!-- <Input class="max-w-sm" placeholder="Buscar por nombre..."
            :model-value="table.getColumn('name')?.getFilterValue() as string"
            @update:model-value=" table.getColumn('name')?.setFilterValue($event)" /> -->
    </div>
    <div class="border-b">
        <Table>
            <TableHeader>
                <TableRow class="hover:bg-transparent" v-for="headerGroup in table.getHeaderGroups()"
                    :key="headerGroup.id">
                    <TableHead class="min-w-36 md:min-w-0" v-for="header in headerGroup.headers" :key="header.id">
                        <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                            :props="header.getContext()" />
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <template v-if="table.getRowModel().rows?.length">
                    <template v-for="row in table.getRowModel().rows" :key="row.id">
                        <TableRow :data-state="row.getIsSelected() ? 'selected' : undefined">
                            <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                            </TableCell>
                        </TableRow>
                        <TableRow v-if="row.getIsExpanded()">
                            <TableCell :colspan="row.getAllCells().length">
                                <slot name="expanded" :row="row"></slot>
                            </TableCell>
                        </TableRow>
                    </template>
                </template>
                <template v-else>
                    <TableRow>
                        <TableCell :colspan="columns.length" class="h-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <span>
                                    Sin resultados...
                                </span>
                            </div>
                        </TableCell>
                    </TableRow>
                </template>
            </TableBody>
        </Table>
    </div>

    <div class="flex flex-col items-center justify-center py-4 gap-5 md_gap-2">
        <span class="text-sm text-muted-foreground self-start">En total hay {{ table.getRowCount() }} {{ name }}.</span>
        <div class="space-x-2">
            <Pagination v-slot="{ page }" :items-per-page="pagination.pageSize" :total="props.data.length"
                :default-page="pagination.pageIndex + 1" @update:page="(newPage) => {
                    pagination.pageIndex = newPage - 1
                }">
                <PaginationContent v-slot="{ items }" class="flex items-center gap-1">
                    <!-- <PaginationFirst @click="table.firstPage()">
                        <ChevronFirst />
                    </PaginationFirst> -->
                    <PaginationPrevious :disabled="!table.getCanPreviousPage()" @click="table.previousPage()">
                        <ChevronLeft />
                        Atras
                    </PaginationPrevious>

                    <template v-for="(item, index) in items" :key="index">
                        <PaginationItem v-if="item.type === 'page'" :value="item.value" as-child>
                            <Button class="w-9 h-9 p-0" :variant="item.value === page ? 'default' : 'outline'"
                                @click="pagination.pageIndex = item.value - 1">
                                {{ item.value }}
                            </Button>
                        </PaginationItem>
                        <PaginationEllipsis v-else :index="index" />
                    </template>

                    <PaginationNext :disabled="!table.getCanNextPage()" @click="table.nextPage()">
                        Siguiente
                        <ChevronRight />
                    </PaginationNext>
                    <!-- <PaginationLast @click="table.lastPage()">
                        <ChevronLast />
                    </PaginationLast> -->
                </PaginationContent>
            </Pagination>
        </div>

    </div>
</template>

<script setup lang="ts" generic="TData, TValue">
import type { ColumnDef, ColumnFiltersState, SortingState } from '@tanstack/vue-table'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'

import {
    FlexRender,
    getCoreRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    useVueTable,
} from '@tanstack/vue-table'

import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination'

import { valueUpdater } from '~/lib/utils'
import Button from '~/components/ui/button/Button.vue';
import Input from '~/components/ui/input/Input.vue';
import { ChevronFirst, ChevronLast, ChevronLeft, ChevronRight, CirclePlus, RefreshCw } from 'lucide-vue-next';
import PaginationContent from '~/components/ui/pagination/PaginationContent.vue'
import PaginationItem from '~/components/ui/pagination/PaginationItem.vue'

const props = withDefaults(defineProps<{
  name: string
  columns: ColumnDef<TData, TValue>[]
  data: TData[]
  canCreate?: boolean
}>(), {
  canCreate: true
})

const emits = defineEmits(['create', 'refresh'])

const sorting = ref<SortingState>([])

const pagination = ref({
    pageIndex: 0,
    pageSize: 10
})

const totalPages = computed(() => Math.ceil(props.data.length / pagination.value.pageSize))

const columnFilters = ref<ColumnFiltersState>([])

const table = useVueTable({
    get data() { return props.data },
    get columns() { return props.columns },
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
    onPaginationChange: updaterOrValue => valueUpdater(updaterOrValue, pagination),
    onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
    state: {
        get sorting() { return sorting.value },
        get pagination() { return pagination.value },
        get columnFilters() { return columnFilters.value }
    },
})
</script>

<style scoped></style>