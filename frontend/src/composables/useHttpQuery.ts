export const useHttpQuery = <T>(
    path: string,
    options: Omit<Parameters<typeof $fetch<T>>[1], 'headers'> = {}
  ) => {
    const config = useRuntimeConfig()
    const token = useCookie('token')
  
    return $fetch<T>(`${config.public.apiBase}${path}`, {
      credentials: 'include',
      ...options,
      headers: {
        Accept: 'application/json',
        ...(token.value ? { Authorization: `Bearer ${token.value}` } : {}),
        ...(options as any).headers
      }
    })
  }
  