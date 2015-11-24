function renderStatistic(statistic) {
    google.setOnLoadCallback(drawTable());

    function drawTable() {
        var data = new google.visualization.DataTable();
        var cssClassNames = {'headerRow': 'visualization-table-tr-head'};

        data.addColumn('string', 'Redirect data');
        data.addColumn('string', 'User agent');
        data.addColumn('string', 'URL');

        for (var i = 0; i < statistic.length; i++) {
            data.addRows([
                [statistic[i].redirect_date, statistic[i].user_agent, statistic[i].redirect_link]
            ]);
        }

        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data, {showRowNumber: true, width: '80%', height: '100%', 'cssClassNames': cssClassNames});
        $('#table_div').show("slow");
    }
}

function isValidUrl(url) {
    var objREG = /(ftp|http|https):/;
    return objREG.test(url);
}

$(document).ready(function () {

    localStorage.setItem('isShowStatistic', false);

    ($('#input_url').val() == '') ? $('#redirect').prop('disabled', true) : $('#redirect').prop('disabled', false);

    $('#input_url').keyup(function () {
        ($('#input_url').val() == '') ? $('#redirect').prop('disabled', true) : $('#redirect').prop('disabled', false);
    });

    $('#custom_link').click(function () {
        if ($('#input_short_link').attr('type') == 'hidden') {
            $('#input_short_link').attr('type', 'text');
            $('#redirect').prop('disabled', true);
        } else {
            $('#input_short_link').attr('type', 'hidden');
            $('#redirect').prop('disabled', false);
            ($('#input_url').val() == '') ? $('#redirect').prop('disabled', true) : $('#redirect').prop('disabled', false);
        }
    });

    $('#minimaze').click(function () {
        var input_url = $('#input_url').val();
        var customLink = $('#input_short_link').val();
        var isLimitLink = $('#limit_link').prop('checked');
        var action = (customLink == '') ? 'minimize' : 'minimizeCustomUrl';

        if (isValidUrl(input_url)) {
            $.ajax({
                type: 'GET',
                url: 'src/Application/FormHandler.php',
                data: {
                    url: $('#input_url').val(),
                    action: action,
                    custom_link: customLink,
                    limit_link: isLimitLink
                },
                success: function (data) {
                    var $parse_data = $.parseJSON(data);

                    $("#input_url").val($parse_data.link);
                    if ($parse_data.error) {
                        $('#input_url').notify($parse_data.error, {position: "right"}, 'error');
                    }
                    $('#input_short_link').val('');
                    $('#input_short_link').attr('type', 'hidden');
                    $('#redirect').prop('disabled', false);
                }
            });
        } else {
            $('#input_url').notify('Url is not valid!', {position: "right"}, 'error');
        }
    });

    $('#redirect').click(function () {
        var input_url = $('#input_url').val().replace(' was added!', '');
        $.ajax({
            type: 'GET',
            url: 'src/Application/FormHandler.php',
            data: {
                url: input_url,
                action: 'redirect'
            },
            success: function (data) {
                window.open(data);
            }
        });
    });

    $('#statistic').click(function () {
        if ((localStorage.getItem('isShowStatistic')) == 'true') {
            $('#table_div').hide("slow");
            localStorage.setItem('isShowStatistic', false);
        } else {
            $('#statistic').prop('disabled', true);
            $.ajax({
                type: 'GET',
                url: 'src/Application/FormHandler.php',
                data: {
                    action: 'getStatistic'
                },
                success: function (data) {
                    renderStatistic($.parseJSON(data));
                }
            }).always(function () {
                $('#statistic').prop('disabled', false);
            });

            $('#table_div').show("slow");
            localStorage.setItem('isShowStatistic', true);
        }
    });
});