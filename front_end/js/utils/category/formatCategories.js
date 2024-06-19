/**
 * format category tree
 */
export function formatCategories(categories, parentId = null) {
    return categories.filter(category => category.parent_id == parentId).map(category => {
        let subCategories = formatCategories(categories, category.id)
        let obj = category
        subCategories && subCategories.length > 0 ? obj.subCategories = subCategories : ""
        return obj
    })
}