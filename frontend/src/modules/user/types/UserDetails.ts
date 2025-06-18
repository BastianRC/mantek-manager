import type { WorkOrderRelation } from "~/modules/work-order/types/WorkOrderRelation"
import type { User } from "./User"

export interface UserDetails {
    id: number
    first_name: string
    last_name: string
    email: string
    phone: string
    role: string,
    department: string
    notes: string | null
    avatar_url: string | null
    is_active: boolean
    last_login: Date | null
    work_orders: WorkOrderRelation[]
    created_at: Date
    updated_at: Date | null
    created_by: Pick<User, 'id' | 'first_name' | 'last_name'> | null
    updated_by: Pick<User, 'id' | 'first_name' | 'last_name'> | null
}