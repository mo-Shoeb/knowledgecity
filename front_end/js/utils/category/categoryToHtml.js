import { countCourseOfAllChild } from "../course/countCourseOfAllChild.js"
import { filterCoursesByCategory } from "../course/filterCoursesByCategory.js"

/**
* Create HTML category Tree + child
*/
export function categoryToHtml(category, appendTo = null) {

    let parent = document.querySelector(".categories") // categories side bar

    let categoryHTML = document.createElement("div") // category container
    categoryHTML.classList.add("category-container")

    let categoryMeta = document.createElement("p") // category meta data
    categoryMeta.classList.add("category")

    let categoryTitle = document.createElement("span") // title
    categoryTitle.classList.add("category-title")
    categoryTitle.innerText = category.name
    categoryTitle.setAttribute("data-id", category.id) // id used for course fetching 
    categoryMeta.appendChild(categoryTitle)

    // if (category.count_of_courses && category.count_of_courses > 0) { // add course count if > 0
    let categoryCourseCount = document.createElement("span")
    categoryCourseCount.classList.add("category-count")

    if (!category.parent_id) { // only get child course count for parent main categories
        categoryCourseCount.innerText = countCourseOfAllChild(category)
    } else {
        categoryCourseCount.innerText = category.count_of_courses > 0 ? `(${category.count_of_courses})` : ""
    }

    categoryMeta.appendChild(categoryCourseCount)
    // }


    if (category.subCategories && category.subCategories.length > 0) { // create subcateries if found
        let subCategoryHTML = document.createElement("div")
        subCategoryHTML.classList.add("sub-categories")

        category.subCategories.forEach(subCategory => {
            categoryToHtml(subCategory, subCategoryHTML)
        })

        categoryMeta.appendChild(subCategoryHTML)
    }

    if (!appendTo) {
        categoryHTML.appendChild(categoryMeta)
        parent.appendChild(categoryMeta)
        addClickListnersOnCategoryTitle(parent)

    } else {
        appendTo.appendChild(categoryMeta) // append subcategory 
    }
}

/**
 * Add Click event to all categories 
 */
function addClickListnersOnCategoryTitle(parent) {
    parent.querySelectorAll(".category-title").forEach(category => {
        category.addEventListener("click", filterCoursesByCategory)
    })
}
