/**
 * Refresh section html for requested page and search/filter settings
 *
 * @param sectionPath
 * @param sectionPageNo
 * @param isRefresh Whether refresh button loading state shall be handled
 */
function co_getSectionHtml(sectionPath, sectionPageNo = 1, isRefresh = false) {
    const data = {
        sectionPath: sectionPath,
        sectionPageNo: sectionPageNo,
        q: co_getSearchValue(sectionPath),
        filters: co_getFilters(sectionPath),
        orderBy: co_getOrderBy(sectionPath)
    }
    var spinnerElement = document.getElementById(sectionPath + '-spinner')
    spinnerElement && spinnerElement.classList.add('ajax-request')

    if (isRefresh) {
        var refreshButtonElement = document.getElementById(sectionPath + '-refresh-button')
        refreshButtonElement && refreshButtonElement.classList.add('loading')
    }

    Craft.sendActionRequest('POST', 'contentoverview/section/get-section-html', {data})
        .then((response) => {
            containerElement = document.getElementById(sectionPath)
            containerElement.children[0].innerHTML = response.data.entriesHtml
            if (containerElement.children.length > 1) {
                // Has pagination html?
                containerElement.children[1].innerHTML = response.data.paginateHtml
            }
        })
        .catch((error) => {
            console.log(error.response)
            Craft.cp.displayError(error.response.data.error)
        })
        .finally(() => {
            spinnerElement && spinnerElement.classList.remove('ajax-request')
            if (isRefresh) {
                refreshButtonElement && refreshButtonElement.classList.remove('loading')
            }
        })

}



/**
 * Get search term
 *
 * @param sectionPath
 * @returns {string|*}
 */
function co_getSearchValue(sectionPath) {
    var input = co_getSearchInput(sectionPath)
    if (input === null) {
        return ''
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

/**
 * Reset search inputs and refresh html
 * @param sectionPath
 */
function co_resetSearch(sectionPath) {
    co_getSearchInput(sectionPath).value = ''
    select = co_getSearchAttributesSelect(sectionPath)
    if (select !== null) {
        select.value = ''
    }

    co_getFilterElements().forEach(element => {
        element.value = ''
    })

    co_getSectionHtml(sectionPath)
}

/**
 * Add eventlistener that refreshes section html if enter is pressed
 * @param sectionPath
 */
function co_registerSearchInput(sectionPath) {
    var searchInput = co_getSearchInput(sectionPath)
    if (searchInput) {
        searchInput.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault()
                co_getSectionHtml(sectionPath)
            }
        })
    }
}


function co_getOrderBy(sectionPath) {

    var input = co_getOrderByInput(sectionPath)
    if (input === null) {
        return ''
    }

    return input.value


}

/**
 * Get filters settings
 * @param sectionPath
 * @returns {[]}
 */
function co_getFilters(sectionPath) {
    filters = []

    co_getFilterElements(sectionPath).forEach(element => {
        filter = {
            type: element.dataset['type'],
            handle: element.dataset['handle'],
            value: element.value
        }
        filters.push(filter)
    })

    return filters

}

/**
 * Creates a new entry and opens it in slideout
 *
 *
 * @param sectionHandle
 * @param siteId
 * @param sectionPath
 * @param sectionPageNo
 */
function co_createEntry(sectionHandle, siteId, sectionPath, sectionPageNo) {
    Craft.sendActionRequest("POST", 'entries/create', {data: {section: sectionHandle, siteId: siteId}})
        .then((response) => {
            Craft.cp.displayNotice(response.data.message, response.data.notificationSettings)
            entry = response.data.entry
            co_createElementEditor(entry.id, siteId, entry.draftId, sectionPath, sectionPageNo)
        })
        .catch((error) => {
            Craft.cp.displayError(error.response.data.message)
            console.log(error.response)
        })
}

/**
 * Open slideout editor and refresh section html after submit
 *
 * @param elementId
 * @param siteId
 * @param draftId
 * @param sectionPath
 * @param sectionPageNo
 */
function co_createElementEditor(elementId, siteId, draftId, sectionPath, sectionPageNo) {
    const slideout = Craft.createElementEditor('\\craft\\elements\\Entry', {
        elementId: elementId,
        draftId: draftId,
        siteId: siteId
    })

    // Refresh section
    slideout.on('submit', () => {
        co_getSectionHtml(sectionPath, sectionPageNo)
    })
}

function co_deleteEntry(elementId, draftId, title, sectionPath, sectionPageNo = 1) {
    if (!confirm('Delete ' + title + '?')) {
        return
    }

    action = draftId ? 'elements/delete-draft' : 'elements/delete'

    Craft.sendActionRequest("POST", action, {data: {elementId: elementId, draftId: draftId}})
        .then((response) => {
            Craft.cp.displayNotice(response.data.message)
            co_getSectionHtml(sectionPath, sectionPageNo)
        })
        .catch((error) => {
            Craft.cp.displayError(error.response.data.message)
        })

}

function co_postAction(action, label, elementId, draftId, title, sectionPath, sectionPageNo = 1) {
    if (!confirm('Execute "' + label + '" for entry "' + title + '"?')) {
        return
    }

    Craft.sendActionRequest("POST", action, {data: {elementId: elementId, draftId: draftId}})
        .then((response) => {
            Craft.cp.displayNotice(response.data.message, response.data.notificationSettings)
            if (response.data.redirect) {
                location.href = response.data.redirect
            } else {
                co_getSectionHtml(sectionPath, sectionPageNo)
            }
        })
        .catch((error) => {
            Craft.cp.displayError(error.response.data.message)
        })

}

/*
Get input element(s) by sectionPath
 */

function co_getSearchInput(sectionPath) {
    return document.getElementById(sectionPath + '-search')
}

function co_getSearchAttributesSelect(sectionPath) {
    return document.getElementById(sectionPath + '-search-attribute')
}

function co_getOrderByInput(sectionPath) {
    return document.getElementById(sectionPath + '-orderby')
}

function co_getFilterElements(sectionPath) {
    return document.getElementsByName(sectionPath + '-filter')
}


function respondToVisibility(element, callback, root = null) {
    var options = {
        root: root
    }

    var observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                callback(entry.intersectionRatio > 0);
                observer.disconnect()
            }
        });
    }, options);

    observer.observe(element);
}