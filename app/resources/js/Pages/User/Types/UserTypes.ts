export interface UserTypes {
    id?: number,
    lastname?: string,
    firstname?: string, 
    name: string,
    username: string,
    password?: string,
    position: string,
    roles?: RoleTypes[]
}

export interface RoleTypes {
    name: string
}

export interface PaginationTypes {
    current_page: number,
    from: number,
    per_page:number,
    to: number,
    total: number,
}

export interface UserPaginationTypes extends PaginationTypes {
    data:  UserTypes[]
}

export interface FilterUserTypes {
    page?: number,
    sortBy?: string,
    sortType?: 'desc'|'asc'|string,
    rows?: number,
    searchString?: string,
}