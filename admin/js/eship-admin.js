eshipBtTableQuote();
eshipBtTableTrackingGuide();
eshipEchartOne();
modalInsertToken();
selectElement();
quotesInputsConfig();

//console.log(jQuery.fn.jquery);
function bsTb(id, data) {
    jQuery(`${id}`).bootstrapTable({
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
        sidePagination: "server",
        pageList: "[25, 50, 100, ALL]",
        pageSize: "25",
        data: data
    });
}

function redirectQuotesEship(href, btnClass, contentText, moreClass = '') {
    let html = `<a class="btn btn-${btnClass}${moreClass} w-100" href="/wp-admin/admin.php?page=${href}">
                    ${contentText}
                </a>`;

    return html;
}

function eshipBtTableQuote() {
    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php?action=get_orders_wc_eship',
    }).done(function (data) {
        if (!data.error) {
            let newOrders = [];
            jQuery.each(data.result, (index, object) => {
                //console.log(object);
                newOrders.push({
                    orderDate: `${object.number} <br> ${object.date_created}`,
                    client: `${object.billing.first_name} ${object.billing.last_name}`,
                    items: object.line_items,
                    shipment: object.shipping,
                    paid: object.status,
                    fulfilled: object.fulfilled,
                    label: `${redirectQuotesEship('eship_dashboard&quotes=' + object.id, 'secondary', 'Ship Now', ' mb-1')}
                            ${redirectQuotesEship('eship_tracking_guide&label_quotes=' + object.id, 'info', 'View Label')}`
                });
            });
            bsTb('#orders', newOrders);
        } else {
            bsTb('#orders', false);
        }
    }).fail(function (data) {
        bsTb('#quotes', false);
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

function eshipEchartOne() {
    // Initialize the echarts instance based on the prepared dom
    if (jQuery('#chart-one').length > 0) {
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
}

function modalInsertToken() {
    jQuery('#tokenEshipModalBtn').on('click', function (e) {
        e.preventDefault();
        let formData = jQuery('#token-input-eship').val();

        if (formData != '') {

            let $data = {
                method: 'POST',
                url: eshipData.url,
                content: {
                    action: 'insert_token_eship',
                    nonce: eshipData.security,
                    token: formData,
                    typeAction: 'add_token'
                },
                type: 'json'
            };

            ajaxEship($data);
        }
    });
}

function ajaxEship($data) {
    jQuery.ajax({
        method: $data.method,
        url: $data.url,
        data: $data.content,
        dataType: $data.type,
        success: function (data) {
            if (data.error == false) {
                console.log('success', data);
                //reload
                if (data.redirect != undefined) {
                    setTimeout(function () {
                        location.href = data.redirect
                    }, 1300);
                } else {
                    return data;
                }
            } else {
                console.log('error datos', data);
            }
        },
        error: function (d, x, v) {
            console.error('d', d);
            console.error('x', x);
            console.error('v', v);
        }
    });
}

function selectElement() {
    if (jQuery('#template-orders') && jQuery('.card').hasClass('show-quotes')) {
        jQuery('#template-orders').show();
    }

    if (jQuery('#custom')) {
        jQuery('#custom').hide();
    }
    if (jQuery('#multipiece')) {
        jQuery('#multipiece').hide();
    }
    if (jQuery('section')) {
        //console.log(select);
        jQuery('section').click(function(){
            switch (jQuery(this).data('select')) {
                case 'template-orders':
                    jQuery('#template-orders').removeClass('show-quotes');
                    jQuery('#template-orders').show();
                    jQuery('#custom').hide();
                    jQuery('#multipiece').hide();
                    break;
                case 'custom':
                    jQuery('#template-orders').hide();
                    jQuery('#custom').show();
                    jQuery('#multipiece').hide();
                    break;
                case 'multipiece':
                    jQuery('#template-orders').hide();
                    jQuery('#custom').hide();
                    jQuery('#multipiece').show();
                    break;
                default:
                    console.log('sin section');
                    break;
            }
        });
    }
}

function quotesInputsConfig() {
    jQuery( "#datepicker" ).datepicker({
        dateFormat:"dd-mm-yy"
    });
}
