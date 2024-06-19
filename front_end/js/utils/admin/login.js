import { fetchData } from "../../fetch.js"

export async function login(username, password){
    return await fetchData("http://api.cc.localhost/admin/login", "POST", JSON.stringify({username, password}), "json")
}

export async function check(){
    return await fetchData("http://api.cc.localhost/admin/status", "GET")
}

export async function logout(){
    await fetchData("http://api.cc.localhost/admin/logout", "GET")
    window.location.reload()
}