export interface Course {
    id:number;
    title:string;
    slug:string;
    description:string;
    price:number;
    level:'beginner'|'intermediate'|'advanced';
    is_published:boolean;
    created_at:string;
    thumbnail:string;
    instructor_id:string;
    category_id:string;
    published_at:string;
    timestamp:number;

}
export interface CreateCourseForm {
    title:string;
    description:string;
    price:number | "";
    level:'beginner'|'intermediate'|'advanced';
    category_id:number | '';
}
export interface Category {
    id:number;
    name:string;
}
