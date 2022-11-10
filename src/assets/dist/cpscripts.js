function co_getSectionHtml(sectionPath, pageNo = 1) {
    // TODO: Add error handling

    const data = {sectionPath: sectionPath, pageNo: pageNo, q: co_getSearchValue(sectionPath)}
    Craft.sendActionRequest('POST', 'contentoverview/section/get-section-html', {data})
        .then((response) => {
            containerElement = document.getElementById(sectionPath)
            containerElement.children[0].innerHTML = response.data.entriesHtml
            containerElement.children[1].innerHTML = response.data.paginateHtml
        });
}


function co_getSearchValue(sectionPath) {
    input = document.getElementById(sectionPath + '-search')
    if (input === null) {
        return '';
    }
    return input.value
}

function co_resetSearch(sectionPath) {
    input = document.getElementById(sectionPath + '-search')
    input.value = ''
    co_getSectionHtml(sectionPath, 1)
}