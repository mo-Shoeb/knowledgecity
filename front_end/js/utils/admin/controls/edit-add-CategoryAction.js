import { getCategories } from "../../../category.js";
import { Swal } from "../../swal.js";
import { createCategory, updateCategory } from "../categories.js";
import { categoryAddEditButton } from "./category-controls.js";

export async function editCategoryAction(result, action, id){
    if (!result.isConfirmed) return

    const { categoryName, categoryParent } = result.value;
    let actionStatus = 
    action == "edit" ? await updateCategory(id, categoryName, categoryParent) : await createCategory(categoryName, categoryParent)
    if(!actionStatus.success){
        Swal.fire({
            title: action == "edit" ? 'Update Error!' : 'Create Error!',
            text: actionStatus.message,
            icon: 'error',
            confirmButtonText: 'OK'
        })
    }else{
        Swal.fire({
            title: action == "edit" ? 'Update Success!' : 'Create Success!',
            text: actionStatus.message,
            icon: 'success',
            confirmButtonText: 'OK'
        })

        await getCategories()
        categoryAddEditButton()
    }
}