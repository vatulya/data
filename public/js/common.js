(function(window, document, $) {

    var $dataContainer = $('#data-container'),
        $dataFiltersForm = $('#data-filters-form'),
        $orderField = $('#orderField'),
        $orderDirection = $('#orderDirection'),
        $d = $(document);

    function getData(data) {
        data = (typeof data === "undefined") ? {} : data;
        $.ajax({
            url: '/?action=data',
            data: data,
            success: function(response) {
                $dataContainer.html(response);
            }
        });
    }
    getData();

    function sendForm() {
        var data = {};
        $.each($dataFiltersForm.serializeArray(), function(i, el) {
            data[el['name']] = el['value'];
        });
        var value = data['filter[value]'] === '' ? data['filter[value-range-min]'] + ' - ' + data['filter[value-range-max]'] : data['filter[value]'];
        delete data['filter[value-range-min]'];
        delete data['filter[value-range-max]'];
        data['filter[value]'] = value;
        getData(data);
    }

    $d.on('click', '.col-sortable', function(e) {
        var $el = $(e.currentTarget);
        $orderField.val($el.data('sort'));
        $orderDirection.val($el.hasClass('sorted-asc') ? 'desc' : 'asc');
        sendForm();
    });

    $d.on('submit', $dataFiltersForm, function(e) {
        e.preventDefault();
        sendForm();
    });

})(window, window.document, window.jQuery);