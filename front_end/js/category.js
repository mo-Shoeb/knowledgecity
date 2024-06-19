import {fetchData, wait, shimmerTimeout} from './fetch.js';
import { loadCategories } from './utils/category/loadCategories.js';
import {formatCategories} from './utils/category/formatCategories.js'

export let allCategories = []
export let rawCategories = []

/**
 * Get Categories From Backend
 */
export async function getCategories() {
    let resp = await fetchData("http://api.cc.localhost/categories", "GET", undefined, "json")
    if (resp && Array.isArray(resp)) {
        
        await wait(shimmerTimeout)  // just to show skeleton loading :)

        allCategories = resp // save formatted categories to allCategories var
        document.querySelector(".categories").innerHTML = ""
        rawCategories = resp
        loadCategories(formatCategories(resp))

    }
}