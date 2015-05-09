var preloader;
preloader = preloader || (function () {
    var el = $('.preloader.modal').clone(true, true);
    return {
        show: function () {
            el.attr('id', 'preloader-modal');
            el.modal();
            el.on('hidden.bs.modal', function () {
                $(this).data('modal', null);
                $('#preloader-modal').remove();
            });
        },
        destroy: function () {
            el.modal('hide');
        }

    };
})();