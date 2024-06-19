import { loadCourses } from "./loadCourses.js"
import { rawCategories } from "./../../category.js"
import { allCourses } from "./../../course.js"
import { mapSubCategories } from "./mapSubCats.js"
/**
 * Get Selected Category Courses And Child Categories Courses IF FOUND
 */
export function filterCoursesByCategory(event) {
    let clickedElement = event.target
    
    if(!clickedElement.hasAttribute("data-id")) return

    document.querySelectorAll(".active").forEach(elem => elem.classList.remove("active")) // reset active class
    clickedElement.parentElement.classList.add("active")
    
    let categoryName = clickedElement.innerText
    let categoryId = clickedElement.getAttribute("data-id")

    document.querySelector(".header").innerText = categoryName // set course header name

    let childCategories = mapSubCategories(rawCategories.find(category => category.id == categoryId))

    loadCourses(
        allCourses.filter(course => childCategories.indexOf(course.category_id) > -1)
    ) // show category courses
}