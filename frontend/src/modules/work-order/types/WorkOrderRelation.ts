export interface WorkOrderRelation {
    id: number,
    order_number: string,
    name: string,
    status: string,
    type: string,
    asignee: string,
    created_at: Date,
    due_at: Date
}