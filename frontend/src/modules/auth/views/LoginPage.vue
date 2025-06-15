<template>
    <div>
        <div class="relative h-screen w-screen 
               before:absolute before:inset-0 
               before:content-[''] 
               before:bg-blue-400/60 md:before:bg-slate-100 
               before:z-10">

            <img class="absolute z-0 min-h-screen w-full object-cover object-center blur-sm md:hidden"
                src="https://www.fama.es/storage/media/thumbs/b635830e423a26a050a8f823acfb559cb358ab5b" alt="Image" />

            <div class="relative z-20 text-slate-50">
                <div class="z-10 flex h-screen w-screen flex-col items-center justify-center gap-10">
                    <div>
                        <div class="w-full flex justify-center">
                            <img :src="imgLogo" class="w-16" alt="Logo Manntek Manager">
                        </div>
                        <h1 class="w-full text-center text-3xl font-semibold text-slate-50 md:text-slate-600">
                            Mantek Manager
                        </h1>
                        <h1 class="w-full text-center text-lg font-normal text-slate-50 md:text-slate-400">
                            Gestor de Mantenimiento
                        </h1>
                    </div>
                    <LoginCard>
                        <LoginForm @submit="onLogin" :loading="isPending" />
                    </LoginCard>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import LoginCard from '../components/LoginCard.vue';
import LoginForm from '../components/LoginForm.vue';
import imgLogo from '@/assets/images/logo.png'
import { useLogin } from '../composables/useLogin';

const { mutate: login, isPending } = useLogin()

const onLogin = async (payload: { email: string; password: string }) => {
    login(payload)
}

</script>

<style scoped></style>