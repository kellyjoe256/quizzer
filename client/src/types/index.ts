export interface User {
    id?: number;
    name?: string;
    email?: string;
    is_admin?: boolean;
    created_at?: string | null;
    updated_at?: string | null;
}

export interface Quiz {
    id?: number;
    name?: string;
    description?: string;
    user_id?: number | null;
    created_at?: string | null;
    updated_at?: string | null;
    user?: User | null;
}

export interface Question {
    id?: number;
    text?: string;
    quiz_id?: number | null;
    created_at?: string | null;
    updated_at?: string | null;
}

export interface Pagination {
    current_page?: number;
    from?: number;
    last_page?: number;
    per_page?: number;
    to?: number;
    total?: number;
}

export interface PaginatorQuery {
    [key: string]: any;
    page: number;
    limit: number;
}
