/**
 * LOOP inside category and find all sub categories id  
 */
export function mapSubCategories(categoryObject, ids = []) {

    ids.push(categoryObject.id)

    if (categoryObject.subCategories && categoryObject.subCategories.length > 0) {
        categoryObject.subCategories.forEach(subCategory => {
            mapSubCategories(subCategory, ids)
        })
    }

    return ids
}
