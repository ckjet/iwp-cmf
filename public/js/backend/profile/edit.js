$(function () {
    var divs = $('<div>', {
        'class': 'help-div'
    });
    $('body').prepend(divs);
    $(window).mousemove(function(pos) {
        if (pos.pageX + $(".helpdiv").width() + 40 > $(window).width() && pos.pageY + $(".help-div").height() + 40 > $(window).height()) {
            $(".help-div").css('left', (pos.pageX - $(".helpdiv").width() - 20) + 'px');
            $(".help-div").css('top', (pos.pageY - $(".helpdiv").height() - 20) + 'px');
        } else if (pos.pageX + $(".helpdiv").width() + 40 > $(window).width()) {
            $(".help-div").css('left', (pos.pageX - $(".helpdiv").width() - 20) + 'px').css('top', (pos.pageY + 20) + 'px');
        } else if (pos.pageY + $(".helpdiv").height() + 40 > $(window).height()) {
            $(".help-div").css('top', (pos.pageY - $(".helpdiv").height() - 20) + 'px').css('left', (pos.pageX + 10) + 'px');
        } else {
            $(".help-div").css('left', (pos.pageX + 10) + 'px').css('top', (pos.pageY + 20) + 'px');
        }
    });
    
    $.help.init();
});

$.help = {
    reinit: function() {
        $('.help-desc').unbind("mouseenter");
        $('.help-desc').unbind("mouseleave");
        this.init();
    },
    init: function() {
        $('.help-desc').bind("mouseenter", function() {
            $(".help-div").html('<p class="col6 b-eff0 ta-c fs8"><img src="' + $(this).attr('data-src') + '"'+($(this).attr('data-width') !=='0' ? ' width="'+$(this).attr('data-width')+'"' : '')+'+'+($(this).attr('data-height') !=='0' ? ' height="'+$(this).attr('data-height')+'"' : '')+' /></p>');
            $(".help-div").show();
        });
        $('.help-desc').bind("mouseleave", function() {
            $(".help-div").hide();
        });
    }
};