<template>
    <div class="flex h-3/5 px-5 w-full items-center justify-center">
        <div class="hidden h-full w-full max-w-2xl rounded-l-xl bg-slate-50 md:block shadow-xl">
            <div class="relative h-full w-full 
                 before:absolute before:inset-0 before:z-10 
                 before:rounded-l-xl before:content-[''] 
                 before:bg-blue-400/60 before:backdrop-blur-xs">

                <div class="absolute left-1/2 top-1/2 z-20 w-full -translate-x-1/2 -translate-y-1/2 text-center">
                    <span class="mb-5 block text-7xl font-bold">DS Corp.</span>
                    <span class="mx-5 text-xl font-medium capitalize">Desarrollador de software empresarial</span>
                </div>

                <img class="z-0 h-full w-full rounded-l-xl object-cover object-center"
                    src="https://www.fama.es/thumb/750/750/0/files/shares/empresa/por-que-fama/produccion-01-fachada.jpg"
                    alt="Image" />
            </div>
        </div>

        <Card class="h-full w-full max-w-2xl border-none bg-slate-50 
               max-sm:w-full max-md:w-[80%] min-w-xs md:rounded-l-none 
               flex items-center justify-center shadow-xl">

            <div class="w-full sm:w-[90%] md:w-[80%]">
                <CardHeader>
                    <CardTitle class="text-center text-3xl font-bold md:mb-8">Inicio de Sesión</CardTitle>
                    <CardTitle class="mb-8 text-center text-xl font-normal md:hidden md:text-3xl md:font-bold">DS Corp.
                    </CardTitle>
                </CardHeader>

                <CardContent>
                    <slot></slot>
                </CardContent>
            </div>
        </Card>
    </div>
</template>

<script setup lang="ts">
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
</script>

<style scoped></style>