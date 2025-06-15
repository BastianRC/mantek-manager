import { defineStore } from 'pinia'

type SubmitFn = () => Promise<any>

export const useSubmitRegistry = defineStore('submitRegistry', () => {
    const submitters = ref<SubmitFn[]>([])

    function register(fn: SubmitFn) {
        submitters.value.push(fn)
    }

    function clear() {
        submitters.value = []
    }

    async function submitAll() {
        return Promise.all(submitters.value.map(fn => fn()))
    }

    return {
        register,
        submitAll,
        clear,
    }
})
