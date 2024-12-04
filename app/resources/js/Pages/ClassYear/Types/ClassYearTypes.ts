export interface ClassYearTypes {
    id?: number,
    class?: number,
    year?: number,
    cl?: string
}

export interface PaginationTypes {
    current_page: number,
    from: number,
    per_page:number,
    to: number,
    total: number,
}

export interface ClassYearPaginationTypes extends PaginationTypes {
    data:  ClassYearTypes[]
}

export interface FilterClassYearTypes {
    page?: number,
    sortBy?: string,
    sortType?: 'desc'|'asc'|string,
    rows?: number,
    searchString?: string,
}