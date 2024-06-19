import { getCourses } from "../../../course.js";
import { Swal } from "../../swal.js"
import { deleteCourse } from "../courses.js";
import { courseAddEditButton } from "./course-controls.js";

export function confirmDelete(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "You will Delete this course ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete!',
        cancelButtonText: 'Cancel'
    }).then(async (result) => {
        removeCourseAction(result, id)
    });
} 

export async function removeCourseAction(result, id){
    if (!result.isConfirmed) return

    let actionStatus = await deleteCourse(id)

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

        await getCourses()
        courseAddEditButton()
    }
}