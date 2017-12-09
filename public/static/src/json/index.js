$(function () {
    $('#jsonInput').change(function () {
        var data = $(this).val();
        try {
            var obj = JSON.parse(data);
        } catch (e) {
            var $modal = $('#jsonError');
            $modal.find('.am-modal-bd').text(e.message);
            $modal.modal();
            return false;
        }
        var json = JSON.stringify(obj, null, '    ');
        $('#parseContent').empty().append('<pre>' + json + '</pre>');
    });
});
