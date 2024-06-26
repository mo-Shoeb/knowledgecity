import { fetchData } from "../../fetch.js"

export async function createCourse(course_id, title, description , image_preview, category_id){
    let resp = await fetchData("http://api.cc.localhost/admin/courses/create", "POST", JSON.stringify(
        {
            course_id,
            title,
            description,
            image_preview,
            category_id
        }
    ))
    return resp
}

export async function updateCourse(course_id, title, description , image_preview, category_id){
    let resp = await fetchData("http://api.cc.localhost/admin/courses/update/" + course_id, "POST", JSON.stringify(
        {
            title,
            description,
            image_preview,
            category_id
        }
    ))
    return resp
}

export async function deleteCourse(id){
    let resp = await fetchData("http://api.cc.localhost/admin/courses/delete/" + id, "GET")
    return resp
}