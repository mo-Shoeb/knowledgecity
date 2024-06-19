import { getCourses } from "../../../course.js";
import { Swal } from "../../swal.js";
import { createCourse, updateCourse } from "../courses.js";
import { courseAddEditButton } from "./course-controls.js";

export async function editCourseAction(result, action){
    if (!result.isConfirmed) return

    const { 
        courseId,
        courseName,
        courseDesc,
        courseImage,
        courseParent
     } = result.value;

    let actionStatus = 
    action == "edit" ? 
    await updateCourse(courseId, courseName, courseDesc, courseImage, courseParent) : 
    await createCourse(courseId, courseName, courseDesc, courseImage, courseParent)

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

        await getCourses()
        courseAddEditButton()
    }
}