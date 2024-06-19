/**
* Create Courses HTML 
*/
export function loadCourses(courses) {

    let parent = document.querySelector(".course-container")
    parent.innerHTML = "" // reset courses

    if (courses.length == 0) {
        parent.innerHTML = "<h1 class='oopsHeading'>Opps &#128584;, no courses here &#128586;</h1>"
    }

    courses.forEach(course => {
        let container = document.createElement("div") // main course container
        container.classList.add("course")
        container.setAttribute("data-id", course.id)

        let image = document.createElement("img") // create image tag
        image.classList.add("course-image")
        image.src = course.preview

        let tag = document.createElement("span") // create course TAG "Category"
        tag.classList.add("course-tag")
        tag.innerText = course.main_category_name

        let title = document.createElement("p") // course title
        title.classList.add("course-title")
        title.innerText = course.name

        let disc = document.createElement("p") // course disc
        disc.classList.add("course-disc")
        disc.innerText = course.description

        container.appendChild(image)
        container.appendChild(tag)
        container.appendChild(title)
        container.appendChild(disc)
        parent.appendChild(container)

    })
}
