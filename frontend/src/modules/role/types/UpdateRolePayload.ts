export interface UpdateRolePayload {
    name?: string,
    description?: string,
    color?: string,
    is_active?: boolean,
    permissions?: string[]
}