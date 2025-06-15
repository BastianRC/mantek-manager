export interface UpdateLocationPayload {
    name?: string | null;
    type?: string | null;
    description?: string | null;
    address?: string | null;
    floor?: number | null;
    latitude?: number | null;
    longitude?: number | null;
    manager_id?: number | null;
    emergency_contact?: string | null;
    emergency_phone?: string | null;
    access_requirements?: string | null;
    operating_hours?: string | null;
    notes?: string | null;
    is_active?: boolean | null;
    updated_by?: number | null;
    zones?: { zone_name: string }[] | null;
    systems?: { system_type: string }[] | null;
}
