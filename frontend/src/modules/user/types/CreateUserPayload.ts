export interface CreateUserPayload {
    first_name: string
    last_name: string
    email: string
    password: string
    phone: string
    department: string
    notes?: string | null
    avatar_url?: string | null
    is_active?: boolean
    role: string
}