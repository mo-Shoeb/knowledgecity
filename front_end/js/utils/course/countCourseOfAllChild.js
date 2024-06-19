/**
 * Count course of child categories
 */
export function countCourseOfAllChild(category, final = true) {
    let count = category.count_of_courses
    if (category.subCategories && category.subCategories.length > 0) {
        category.subCategories.forEach(subCategory => {
            count += countCourseOfAllChild(subCategory, false) ?? 0
        })
    }
    if (final) {
        if (count > 0) return `(${count})`
        return ""
    }
    return count
}