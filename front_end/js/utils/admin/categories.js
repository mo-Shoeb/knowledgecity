import { fetchData } from "../../fetch.js"

export async function findCategory(categoryId){
    let resp = await fetchData("http://api.cc.localhost/catgories/" + categoryId, "GET", undefined, "json")
    console.log(resp)
}

export async function createCategory(name, parent_id){
    let resp = await fetchData("http://api.cc.localhost/admin/catgories/create", "POST", JSON.stringify(
        {
            name, 
            parent_id
        }
    ))
    return resp
}

export async function updateCategory(id, name, parent_id){
    let resp = await fetchData("http://api.cc.localhost/admin/catgories/update/" + id, "POST", JSON.stringify(
        {
            name, 
            parent_id
        }
    ))
    return resp
}

export async function deleteCategory(id){
    let resp = await fetchData("http://api.cc.localhost/admin/catgories/delete/" + id, "GET")
    return resp
}