export let shimmerTimeout = 0 // 2 seconds

/**
 * Fetch Function
 */
export function fetchData(url, method, body = undefined, respType = "json") {
    return new Promise(async (resolve) => {
        let resp = await fetch(url, {
            method,
            body,
            headers:{
                "content-type": "application-json"
            },
            credentials: 'include'
        })
        if (respType == "json") return resolve(await resp.json())
        if (respType == "text") return resolve(await resp.text())
    })
}

export function wait(seconds){
    return new Promise((resolve)=>{
        setTimeout(()=>{resolve()}, seconds)
    })
}