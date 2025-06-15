// composables/useSubmitRegistry.ts
import { ref } from 'vue'

type SubmitFn = () => Promise<any>

const submitters = ref<SubmitFn[]>([])

export function useSubmitRegistry() {
    const register = (fn: SubmitFn) => {
        submitters.value.push(fn)
    }

    const clear = () => {
        submitters.value = []
    }

    const submitAll = async () => {
        return Promise.all(submitters.value.map(fn => fn()))
    }

    return {
        register,
        submitAll,
        clear,
    }
}
