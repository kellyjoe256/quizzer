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
    [key: string]: any;
}

export interface Question {
    id?: number;
    text?: string;
    quiz_id?: number | null;
    created_at?: string | null;
    updated_at?: string | null;
    [key: string]: any;
}

export interface Answer {
    id?: number;
    value?: string;
    is_true?: boolean;
    question_id?: number | null;
    created_at?: string | null;
    updated_at?: string | null;
    [key: string]: any;
}

export interface Pagination {
    current_page?: number;
    from?: number;
    last_page?: number;
    per_page?: number;
    to?: number;
    total?: number;
    [key: string]: any;
}

export interface PaginatorQuery {
    page: number;
    limit: number;
    [key: string]: any;
}
