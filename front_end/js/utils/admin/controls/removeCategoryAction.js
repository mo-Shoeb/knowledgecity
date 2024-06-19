import { getCategories } from "../../../category.js"
import { Swal } from "../../swal.js"
import { deleteCategory } from "../categories.js"
import { categoryAddEditButton } from "./category-controls.js"

export function confirmDelete(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "You will Delete this item ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete!',
        cancelButtonText: 'Cancel'
    }).then(async (result) => {
        removeCategoryAction(result, id)
    });
} 

export async function removeCategoryAction(result, id){
    if (!result.isConfirmed) return

    let actionStatus = await deleteCategory(id)

    if(!actionStatus.success){
        Swal.fire({
            title: 'Delete Error!',
            text: actionStatus.message,
            icon: 'error',
            confirmButtonText: 'OK'
        })
    }else{
        Swal.fire({
            title: 'Delete Success!',
            text: actionStatus.message,
            icon: 'success',
            confirmButtonText: 'OK'
        })

        await getCategories()
        categoryAddEditButton()
    }
}