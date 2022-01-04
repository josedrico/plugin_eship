eshipBtTableQuote();
eshipBtTableTrackingGuide();
eshipEchartOne();

console.log(jQuery.fn.jquery);

function eshipBtTableQuote() {
    jQuery('#quotes').bootstrapTable({
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

function eshipEchartOne(){
    // Initialize the echarts instance based on the prepared dom
    let myChart = echarts.init(document.getElementById('chart-one'));

    // Specify the configuration items and data for the chart
    let option = {
        title: {
            text: 'ECharts Getting Started Example'
        },
        tooltip: {},
        legend: {
            data: ['sales']
        },
        xAxis: {
            data: ['Shirts', 'Cardigans', 'Chiffons', 'Pants', 'Heels', 'Socks']
        },
        yAxis: {},
        series: [
            {
                name: 'sales',
                type: 'bar',
                data: [5, 20, 36, 10, 10, 20]
            }
        ]
    };

    // Display the chart using the configuration items and data just specified.
    myChart.setOption(option);
}