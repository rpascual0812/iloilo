(function ( $ ) {
    $.fn.shoutout = function( options ) {
        var motherdiv = this;

        //$(this).addClass('shoutout-position');

        // var newTop =   $(window).height() - 50;
        // var newLeft = ($(window).width()  - $(this).width()) / 2;
        // $(this).css({
        //     'position': 'absolute',
        //     'left': newLeft - 450,
        //     'top': newTop
        // });
        
        // var settings = $.extend({
        //     type: "",
        //     msg: ""
        // }, options );

        $(this).children('#msg').empty().append(options.msg);

        $(this).removeClass('alert-success');
        $(this).removeClass('alert-warning');
        $(this).removeClass('alert-info');
        $(this).removeClass('alert-danger');

        $(this).children('#icon').removeClass('fa-check');
        $(this).children('#icon').removeClass('fa-warning');
        $(this).children('#icon').removeClass('fa-info');
        $(this).children('#icon').removeClass('fa-ban');

        if(options.type == 'success'){
            $(this).addClass('alert-success');
            $(this).children('#icon').addClass('fa-check');
        }
        else if(options.type == 'warning'){
            $(this).addClass('alert-warning');
            $(this).children('#icon').addClass('fa-warning');
        }
        else if(options.type == 'info'){
            $(this).addClass('alert-info');
            $(this).children('#icon').addClass('fa-info');
        }
        else {
            $(this).addClass('alert-danger');
            $(this).children('#icon').addClass('fa-ban');
        }
        

        $(this).slideUp(2000, function(){
            $(this).show();
        });

        setTimeout(function(){
            $(motherdiv).fadeOut(3000, function(){
                $(motherdiv).hide();  
            });     
        }, 5000);
    };
}( jQuery ));