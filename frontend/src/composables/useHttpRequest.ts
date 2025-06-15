export const useHttpRequest = async <T>(
    path: string,
    options: Omit<Parameters<typeof $fetch<T>>[1], 'headers'> = {}
  ): Promise<T> => {
    const config = useRuntimeConfig()
    const token = useCookie('token')
  
    return await $fetch<T>(`${config.public.apiBase}${path}`, {
      credentials: 'include',
      ...options,
      headers: {
        Accept: 'application/json',
        ...(token.value ? { Authorization: `Bearer ${token.value}` } : {}),
        ...(options as any).headers
      }
    })
  }
  