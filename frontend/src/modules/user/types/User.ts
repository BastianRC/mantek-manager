export interface User {
    id: number
    first_name: string
    last_name: string
    email: string
    phone: string
    role: string,
    department: string
    avatar_url: string | null
    is_active: boolean
    last_login: Date | null
}