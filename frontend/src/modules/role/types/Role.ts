import type { Permission } from "./Permission";

export interface Role {
    id: number,
    name: string,
    description: string,
    color: string,
    is_active: boolean,
    permissions: Permission[],
    users_count: number,
    created_at: Date,
    updated_at: Date
}