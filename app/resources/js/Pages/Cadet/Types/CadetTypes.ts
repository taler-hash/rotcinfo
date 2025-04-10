export interface CadetTypes {
    id_number?: number,
    firstname?: string,
    lastname?: string,
    name?: string,
    cadet_identifier?: string,
    gender?: 'male'| 'female',
    age?: number,
    dob?: Date,
    address?: string,
    course?: string,
    religion?: string,
    b_type?: string,
    height?: string,
    beneficiary?: string,
    email?: string,
    sem_1_grade?: number,
    sem_2_grade?: number,
    class_year_id?: number,
    subject?: string,
    status?: string,
    password?: string,
    image?: any,
    media?: {
        original_url?: string
    }[]
}

export interface PaginationTypes {
    current_page: number,
    from: number,
    per_page:number,
    to: number,
    total: number,
}

export interface FilterCadetTypes {
    page?: number,
    sortBy?: string,
    sortType?: 'desc'|'asc'|string,
    rows?: number,
    searchString?: string,
    class_year_id?: number
}

export interface CadetPaginationTypes extends PaginationTypes {
    data:  CadetTypes[]
}