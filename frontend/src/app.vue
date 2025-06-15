<template>
    <div>
        <NuxtLayout>
            <NuxtPage />
        </NuxtLayout>

        <ClientOnly>
            <ConfirmDialog />
            <Toaster rich-colors />
        </ClientOnly>
    </div>
</template>

<script setup lang="ts">
import { Toaster } from '@/components/ui/sonner'
import ConfirmDialog from './components/custom/ConfirmDialog/ConfirmDialog.vue';
</script>

<style scoped></style>