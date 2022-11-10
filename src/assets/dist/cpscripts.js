function co_getSectionHtml(sectionPath, pageNo=1)
{
    // TODO: Add error handling
    const data = {sectionPath: sectionPath, pageNo: pageNo}
    Craft.sendActionRequest('POST', 'contentoverview/section/get-section-html', {data})
        .then((response) => {
            containerElement = document.getElementById(sectionPath);
            containerElement.children[0].innerHTML = response.data.entriesHtml;
            containerElement.children[1].innerHTML = response.data.paginateHtml;
        });
}