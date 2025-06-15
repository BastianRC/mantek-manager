import type {
    DehydratedState,
    VueQueryPluginOptions,
} from '@tanstack/vue-query'
import {
    VueQueryPlugin,
    QueryClient,
    hydrate,
    dehydrate,
} from '@tanstack/vue-query'

export default defineNuxtPlugin((nuxt) => {
    const vueQueryState = useState<DehydratedState | null>('vue-query')

    const queryClient = new QueryClient({
        defaultOptions: {
            queries: {
                staleTime: 5000,
                refetchOnWindowFocus: false,
                retry: false,
            },
        },
    })

    const options: VueQueryPluginOptions = { queryClient }

    nuxt.vueApp.use(VueQueryPlugin, options)

    if (import.meta.server) {
        nuxt.hooks.hook('app:rendered', () => {
            vueQueryState.value = dehydrate(queryClient)
        })
    }

    if (import.meta.client && vueQueryState.value) {
        hydrate(queryClient, vueQueryState.value)
    }
    
    /* console.log('✅ Plugin vue-query cargado') */

    return {
        provide: {
            vueQueryClient: queryClient,
        },
    };

})
