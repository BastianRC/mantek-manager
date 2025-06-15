<template>
    <SidebarProvider>
        <AppSidebar />
        <SidebarInset class="w-[calc(100%-var(--sidebar-width))]">
            <header
                class="flex h-16 shrink-0 items-center gap-2 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12">
                <div class="flex items-center gap-2 px-4">
                    <SidebarTrigger class="-ml-2 [&_svg:not([class*='size-'])]:size-6 p-5" />
                    <h4 class="scroll-m-20 text-xl font-light tracking-tight">
                        Mantek Manager
                    </h4>
                </div>
            </header>
            <main class="flex flex-1 flex-col gap-4 p-4 pt-0">
                <slot />
            </main>
        </SidebarInset>
    </SidebarProvider>
</template>

<script setup lang="ts">
import AppSidebar from '~/components/custom/Sidebar/AppSidebar.vue';
import SidebarInset from '~/components/ui/sidebar/SidebarInset.vue';
import SidebarProvider from '~/components/ui/sidebar/SidebarProvider.vue';
import SidebarTrigger from '~/components/ui/sidebar/SidebarTrigger.vue';

</script>

<style scoped></style>