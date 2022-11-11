function co_getSectionHtml(sectionPath, pageNo = 1) {
    // TODO: Add error handling

    const data = {
        sectionPath: sectionPath,
        pageNo: pageNo,
        q: co_getSearchValue(sectionPath),
        filters: co_getFilters(sectionPath)
    }
    Craft.sendActionRequest('POST', 'contentoverview/section/get-section-html', {data})
        .then((response) => {
            containerElement = document.getElementById(sectionPath)
            containerElement.children[0].innerHTML = response.data.entriesHtml
            if (containerElement.children.length > 1) {
                // Has pagination html?
                containerElement.children[1].innerHTML = response.data.paginateHtml
            }
        });
}


function co_getSearchValue(sectionPath) {
    input = co_getSearchInput(sectionPath)
    if (input === null) {
        return '';
    }

    value = input.value

    select = co_getSearchAttributesSelect(sectionPath)
    if (select !== null) {
        attribute = select.value
        if (attribute !== '') {
            value = attribute + ':' + value
        }
    }

    return value
}

function co_resetSearch(sectionPath) {
    co_getSearchInput(sectionPath).value = ''
    select = co_getSearchAttributesSelect(sectionPath)
    if (select !== null) {
        select.value = ''
    }

    co_getFilterElements().forEach(element => {element.value = ''})

    co_getSectionHtml(sectionPath)
}

function co_getSearchInput(sectionPath) {
    return document.getElementById(sectionPath + '-search')
}

function co_getSearchAttributesSelect(sectionPath) {
    return document.getElementById(sectionPath + '-search-attribute')
}

function co_getFilterElements(sectionPath) {
    return document.getElementsByName(sectionPath + '-filter')
}

function co_registerSearchInput(sectionPath) {
    co_getSearchInput(sectionPath).addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            co_getSectionHtml(sectionPath);
        }
    })
}

function co_getFilters(sectionPath) {
    filters = [];


    co_getFilterElements(sectionPath).forEach(element => {
        filter = {
            type: element.dataset['type'],
            field: element.dataset['field'],
            value: element.value
        }
        filters.push(filter)
    })

    console.log(filters)

    return filters;

}