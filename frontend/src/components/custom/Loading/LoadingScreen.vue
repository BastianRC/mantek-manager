<template>

        <Teleport to="#teleports">
            <div v-if="visible"
                class="fixed inset-0 z-[100] bg-black/50 flex items-center justify-center backdrop-blur-xs">
                <div class="flex flex-col items-center">
                    <div class="w-44 mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 150">
                            <path fill="none" stroke="#FFFFFF" stroke-width="8" stroke-linecap="round"
                                stroke-dasharray="300 385" stroke-dashoffset="0"
                                d="M275 75c0 31-27 50-50 50-58 0-92-100-150-100-28 0-50 22-50 50s23 50 50 50c58 0 92-100 150-100 24 0 50 19 50 50Z">
                                <animate attributeName="stroke-dashoffset" calcMode="spline" dur="3" values="685;-685"
                                    keySplines="0 0 1 1" repeatCount="indefinite"></animate>
                            </path>
                        </svg>
                    </div>
                    <span class="text-2xl text-muted animate-bounce">Cargando...</span>
                </div>
            </div>
        </Teleport>

</template>

<script setup lang="ts">
const props = defineProps<{
    visible: boolean
}>()

watch(() => props.visible, (isVisible) => {
    document.body.style.overflow = isVisible ? 'hidden' : ''
})

onBeforeMount(() => {

})

</script>

<style scoped></style>