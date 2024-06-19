import { logoutSwal } from "../../admin-login.js"
import { categoryAddEditButton } from "./controls/category-controls.js"
import { courseAddEditButton } from "./controls/course-controls.js"

/**
 * Build admin UI
 */
export function buildAdminElements(){
    addLogoutButton()
    categoryAddEditButton() // category controls
    courseAddEditButton() // course controls
}

/**
 * Remove login button
 * add    logout button
 */
function addLogoutButton(){
    document.querySelector(".admin-login").remove()
    
    let button = document.createElement("button")
    button.innerText = "Log out"
    button.classList.add("admin-logout")
    button.addEventListener("click", logoutSwal)

    document.querySelector(".admin-control").appendChild(button)

}
