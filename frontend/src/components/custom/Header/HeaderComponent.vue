<template>
    <div class="pb-16 mt-10 md:pb-3 md:mt-0 border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
        <div class="container mx-auto flex h-16 items-center px-6">
            <div class="flex flex-1 items-center justify-between">
                <div class="flex items-center gap-4">
                    <div>
                        <slot name="backButton"/>
                    </div>
                    <div>
                        <h2 class="text-3xl font-semibold">{{ title }}</h2>
                        <p class="text-muted-foreground">{{ subtitle }}</p>
                    </div>

                </div>

                <div class="flex mr-2 gap-2">
                    <slot name="buttons" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    'title': string,
    'subtitle': string
}>()

const emit = defineEmits(['create'])

</script>

<style scoped></style>