import { rawCategories } from "../../category.js";
import { allCourses } from "../../course.js";
import { Swal } from "../swal.js";
import { editCourseAction } from "./controls/edit-add-CourseAction.js";
import { confirmDelete } from "./controls/removeCourseAction.js";

export function editCourse(id, action = "edit") {

    if (action == "delete") {
        return confirmDelete(id)
    }

    let courseData = getcourseData(id) // get course old data or add new one

    openSwal(action, courseData)

}

function getcourseData(id) {
    return allCourses.find(x => x.id == id)
}

function buildCategoryOptions(selectedId = undefined) {
    return rawCategories.map(category => `<option value="${category.id}" ${category.id == selectedId ? 'selected' : ''}>${category.name}</option>`)
}

function openSwal(action, courseData) {

    Swal.fire({
        title: action == "edit" ? 'Edit Course' : 'Add Course',
        html: `
          <input style="width: 100%; margin: unset" type="${action == 'edit' ? 'hidden' : 'text'}" id="courseId" class="swal2-input" value="${action == 'edit' && courseData?.id || ''}" placeholder="Course ID">
          <input style="width: 100%; margin: unset; margin-top: 10px" type="text" id="courseName" class="swal2-input" value="${action == 'edit' && courseData?.name || ''}" placeholder="Course Name">
          <textarea id="courseDesc" class="swal2-text-area" value="${action == 'edit' && courseData?.description || ''}" placeholder="Course Description">${action == 'edit' && courseData?.description || ''}</textarea>
          <input style="width: 100%; margin: unset; margin-top: 10px" type="text" id="courseImage" class="swal2-input" value="${action == 'edit' && courseData?.preview || ''}" placeholder="Course Image URL">
          
          <select style="width: 100%; margin: unset; margin-top: 10px" id="courseParent" class="swal2-select">
            <option value="" selected>Select Parent Course</option>
            ${buildCategoryOptions(courseData?.category_id)}
          </select>
        `,
        showCancelButton: true,
        confirmButtonText: action == "edit" ? 'Modify' : 'Add',
        preConfirm: () => {
            const courseId = Swal.getPopup().querySelector('#courseId').value;
            const courseName = Swal.getPopup().querySelector('#courseName').value;
            const courseDesc = Swal.getPopup().querySelector('#courseDesc').value;
            const courseImage = Swal.getPopup().querySelector('#courseImage').value;
            const courseParent = Swal.getPopup().querySelector('#courseParent').value;
            
            if (
                !courseId || 
                !courseName ||
                !courseDesc ||
                !courseImage ||
                !courseParent
            ) {
                Swal.showValidationMessage('Please enter all fields');
                return false;
            }

            return {
                courseId,
                courseName,
                courseDesc,
                courseImage,
                courseParent
            };
        }
    }).then(async (result) => {

        editCourseAction(result, action)

    });
}





