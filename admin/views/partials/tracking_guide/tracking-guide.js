eshipBtTableTrackingGuide();

function eshipBtTableTrackingGuide() {
    jQuery('#tracking-guide').bootstrapTable({
        toggle: 'table',
        search: true,
        searchHighlight: true,
        searchOnEnterKey: true,
        showSearchButton: true,
        iconsPrefix: 'dashicons',
        icons: {
            search: 'dashicons-search'
        },
        searchAlign: 'left',
        pagination: true,
        pageList: "[25, 50, 100, ALL]",
        pageSize: "25",
        //data: arrContent
    });
}