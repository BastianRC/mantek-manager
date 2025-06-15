export interface CreateRolePayload {
    name: string,
    description: string,
    color?: string,
    permissions: string[]
}