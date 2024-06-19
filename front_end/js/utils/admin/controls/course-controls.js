import { editCourse } from "../edit-add-course.js"

/**
 * Add Category Controls
 */
export function courseAddEditButton(){

    let parentCreate = document.createElement("i")
    parentCreate.classList.add("fa-solid")
    parentCreate.classList.add("fa-plus")
    parentCreate.addEventListener("click", function(e){
        e.preventDefault()
        editCourse(undefined, "create")
    })
    document.querySelector(".courses").appendChild(parentCreate)

    document.querySelectorAll(".course").forEach(course=>{
        let edit = document.createElement("i")
        edit.classList.add("fa-solid")
        edit.classList.add("fa-pen")
        edit.addEventListener("click", function(e){
            e.preventDefault()
            editCourse(course.getAttribute("data-id"))
        })
        course.appendChild(edit)

        let add = document.createElement("i")
        add.classList.add("fa-solid")
        add.classList.add("fa-plus")
        add.addEventListener("click", function(e){
            e.preventDefault()
            editCourse(course.getAttribute("data-id"), "create")
        })
        course.appendChild(add)

        let deleteCategory = document.createElement("i")
        deleteCategory.classList.add("fa-solid")
        deleteCategory.classList.add("fa-trash")
        deleteCategory.addEventListener("click", function(e){
            e.preventDefault()
            editCourse(course.getAttribute("data-id"), "delete")
        })
        course.appendChild(deleteCategory)
    })
}