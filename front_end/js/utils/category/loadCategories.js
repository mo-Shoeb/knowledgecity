import { allCategories } from "../../category.js"
import { categoryToHtml } from "./categoryToHtml.js"
/**
* Convert Array of categories to HTML
*/
export function loadCategories(categories) {
    categories.forEach(category => {
        categoryToHtml(category)
    })
}