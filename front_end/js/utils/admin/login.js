import { fetchData } from "../../fetch.js"

export async function login(username, password){
    return await fetchData("https://moshoeb.win/knowldgecity/apis/admin/login", "POST", JSON.stringify({username, password}), "json")
}

export async function check(){
    return await fetchData("https://moshoeb.win/knowldgecity/apis/admin/status", "GET")
}

export async function logout(){
    await fetchData("https://moshoeb.win/knowldgecity/apis/admin/logout", "GET")
    window.location.reload()
}