import {fetchData, shimmerTimeout, wait} from './fetch.js';
import {loadCourses} from './utils/course/loadCourses.js'

export let allCourses = []

/**
 * Get All Courses From Backend
 */
export async function getCourses() {
    let resp = await fetchData("https://moshoeb.win/knowldgecity/apis/courses", "GET", undefined, "json")
    if (resp && Array.isArray(resp)) {
        allCourses = resp // save course to allCourses
        
        await wait() // just to show skeleton loading :)

        loadCourses(resp)

    }
}





