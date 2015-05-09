$(function () {
    var num = 0, mStatus = 'closed';
    $('.multiple').select2();
    $('.multiple[name="_o"]').change(function () {
        preloader.show();
        var self = $(this);
        $.ajax({
            url: '/board/getSubOperation.rlt',
            type: 'POST',
            data: {
                '_id': self.val()
            },
            success: function (data) {
                $('select[name="_so"]').html(null);
                $('.sub-operation .select2-container a.select2-choice > span.select2-chosen').html('Не указано');
                preloader.destroy();
                if (data.data.length) {
                    $('.sub-operation .select2-container a.select2-choice > span.select2-chosen').html('Все');
                    var el = $('<option>', {
                        'value': '-1',
                        'text': 'Все'
                    });
                    $('select[name="_so"]').append(el);
                    for (var i = 0; i < data.data.length; i++) {
                        var el = $('<option>', {
                            'value': data.data[i].id,
                            'text': data.data[i].name
                        });
                        $('select[name="_so"]').append(el);
                    }
                    $('select[name="_so"]').removeAttr('disabled');
                } else {
                    $('select[name="_so"]').attr('disabled', 'disabled');
                }
            }
        });
    });
    $('.one-advert').click(function () {
        if (mStatus === 'closed') {
            mStatus = 'opened';
            preloader.show();
            var self = $(this);
            $.ajax({
                url: '/board/getInfo.rlt',
                type: 'POST',
                data: {
                    '_id': self.attr('data-id')
                },
                success: function (data) {
                    if (data.success) {
                        var el = $('.modal_tpl').clone(true, true);
                        el.removeClass('modal_tpl').attr('id', 'advert-info');
                        el.find('.modal-title').html(data.data.name);
                        el.find('.modal-description span').html(data.data.description);
                        el.find('.price').html(data.data.price);
                        el.find('.created_at span').html(data.data.created_at);
                        el.find('.category span').html(data.data.category);
                        el.find('.operation span').html(data.data.operation);
                        el.find('.phone span').html(data.data.phone);
                        el.find('.original_link a').attr('href', data.data.original_link);
                        if (data.data.agency) {
                            el.find('.agency span').html(data.data.agency_name);
                        } else {
                            el.find('.agency').remove();
                        }
                        if (data.data.contactMan) {
                            el.find('.contactMan span').html(data.data.contactMan);
                        } else {
                            el.find('.contactMan').remove();
                        }
                        if (data.data.address) {
                            el.find('.address span').html(data.data.address);
                        } else {
                            el.find('.address').remove();
                        }
                        if (data.data.photos.length) {
                            var nav, item, item_img;
                            for (var i = 0; i < data.data.photos.length; i++) {
                                nav = $('<li>', {
                                    'data-target': '#advert-carousel',
                                    'data-slide-to': i,
                                    'class': (i === 0 ? 'active' : '')
                                });
                                item_img = $('<img>', {
                                    'src': data.data.photos[i].url
                                });
                                item = $('<div>', {
                                    'class': 'item' + (i === 0 ? ' active' : '')
                                });
                                item.append(item_img);
                                el.find('.carousel-indicators').append(nav);
                                el.find('.carousel-inner').append(item);
                            }
                            el.find('.advert-carousel[data-ride="advert-carousel"]').attr('id', 'advert-carousel' + num).attr('data-ride', 'carousel');
                            el.find('#advert-carousel' + num).html(el.find('#advert-carousel' + num).html().replace(/#advert-carousel/g, '#advert-carousel' + num));
                            el.find('#advert-carousel' + num).carousel();
                            num++;
                        } else {
                            el.find('.carousel[data-ride="advert-carousel"]').remove();
                        }
                        if (data.data.confirmed_at) {
                            el.find('input[name="confirmed"]').attr('checked', 'checked');
                        }
                        if (data.data.type === '2') {
                            el.find('input[name="type"]').attr('checked', 'checked');
                        }
                        el.find('form.change-advert').submit(function (e) {
                            e.preventDefault();
                            var formData = $(this).serialize();
                            preloader.show();
                            $.ajax({
                                url: '/board/save.rlt',
                                type: 'POST',
                                data: formData + '&id=' + self.attr('data-id'),
                                success: function (data) {
                                    preloader.destroy();
                                    if (data.success) {
                                        if (data.confirmed) {
                                            $('.one-advert[data-id="' + self.attr('data-id') + '"]').not('.confirmed').addClass('confirmed');
                                            $('.one-advert[data-id="' + self.attr('data-id') + '"] .confirmed').html(data.confirmed);
                                        } else {
                                            $('.one-advert.confirmed[data-id="' + self.attr('data-id') + '"] .confirmed').html(null);
                                            $('.one-advert.confirmed[data-id="' + self.attr('data-id') + '"]').removeClass('confirmed');
                                        }
                                    } else {
                                        alert(data.error);
                                    }
                                }
                            });
                        });
                        $('body').append(el);
                        preloader.destroy();
                        el.modal();
                        el.on('hidden.bs.modal', function () {
                            mStatus = 'closed';
                            $('#advert-info').remove();
                        });
                    } else {
                        alert(data.error);
                    }
                }
            });
        }
    });
});