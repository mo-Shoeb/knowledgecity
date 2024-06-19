import { editCategory } from "../edit-add-category.js"

/**
 * Add Category Controls
 */
export function categoryAddEditButton(){

    let parentCreate = document.createElement("i")
    parentCreate.classList.add("fa-solid")
    parentCreate.classList.add("fa-plus")
    parentCreate.addEventListener("click", function(e){
        e.preventDefault()
        editCategory(undefined, "create")
    })
    document.querySelector(".categories").appendChild(parentCreate)

    document.querySelectorAll(".category-title").forEach(category=>{
        let edit = document.createElement("i")
        edit.classList.add("fa-solid")
        edit.classList.add("fa-pen")
        edit.addEventListener("click", function(e){
            e.preventDefault()
            editCategory(category.getAttribute("data-id"))
        })
        category.appendChild(edit)

        let add = document.createElement("i")
        add.classList.add("fa-solid")
        add.classList.add("fa-plus")
        add.addEventListener("click", function(e){
            e.preventDefault()
            editCategory(category.getAttribute("data-id"), "create")
        })
        category.appendChild(add)

        let deleteCategory = document.createElement("i")
        deleteCategory.classList.add("fa-solid")
        deleteCategory.classList.add("fa-trash")
        deleteCategory.addEventListener("click", function(e){
            e.preventDefault()
            editCategory(category.getAttribute("data-id"), "delete")
        })
        category.appendChild(deleteCategory)
    })
}