export interface AnnouncementTypes {
    id?: number,
    header?: string,
    description?: string
}


export interface PaginationTypes {
    current_page: number,
    from: number,
    per_page:number,
    to: number,
    total: number,
}

export interface AnnouncementPaginationTypes extends PaginationTypes {
    data:  AnnouncementTypes[]
}

export interface FilterAnnouncementTypes {
    page?: number,
    sortBy?: string,
    sortType?: 'desc'|'asc'|string,
    rows?: number,
    searchString?: string,
}