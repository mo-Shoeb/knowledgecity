import { rawCategories } from "../../category.js";
import { Swal } from "../swal.js";
import { editCategoryAction } from "./controls/edit-add-CategoryAction.js";
import { confirmDelete } from "./controls/removeCategoryAction.js";

export function editCategory(id, action = "edit") {

    if( action == "delete" ){
        return confirmDelete(id)
    }

    let categoryData = getCategoryData(id) // get cateogry old data or add new one
    let parents = buildParentOptions(availableParents(), action == "edit" ? categoryData?.parent_id : categoryData?.id) // get parents 

    openSwal(id, action, categoryData, parents)

}

function availableParents() {
    return rawCategories.map(x => {
        return {
            id: x.id,
            parentId: x.parent_id,
            name: x.name
        }
    })
}

function getCategoryData(id) {
    return rawCategories.find(x => x.id == id)
}

function buildParentOptions(parents, selectedId = undefined){
    return parents.map(parent=> `<option value="${parent.id}" ${parent.id == selectedId ? 'selected' : ''}>${parent.name}</option>`)
}

function openSwal(id, action, categoryData, parents){
    Swal.fire({
        title: action == "edit" ? 'Edit Category' : 'Add Category',
        html: `
          <input style="width: 100%; margin: unset" type="text" id="categoryName" class="swal2-input" value="${action == 'edit' && categoryData?.name || ''}" placeholder="Category Name">
          <select style="width: 100%; margin: unset; margin-top: 10px" id="categoryParent" class="swal2-select">
            <option value="" selected>Select Parent Category (optional)</option>
            ${parents}
          </select>
        `,
        showCancelButton: true,
        confirmButtonText: action == "edit" ? 'Modify' : 'Add',
        preConfirm: () => {
            const categoryName = Swal.getPopup().querySelector('#categoryName').value;
            const categoryParent = Swal.getPopup().querySelector('#categoryParent').value;

            if (!categoryName || !categoryParent) {
                Swal.showValidationMessage('Please enter both Name and Category');
                return false;
            }
            
            return { categoryName: categoryName, categoryParent: categoryParent };
        }
    }).then(async (result) => {

        editCategoryAction(result, action, id)

    });
}





