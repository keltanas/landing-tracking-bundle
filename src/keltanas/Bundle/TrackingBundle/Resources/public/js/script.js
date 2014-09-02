(function(window, document, $, Backbone, formView){
    $(function(){
        $('form').each(function(){
            new formView({'el': this});
        });
        $(document).on('form.success', function(e, response, $form){
            $(document).trigger('yandex.reachGoal', {target: $form.attr('name')});
            $form.parent().html(
                '<h3><i class="glyphicon glyphicon-ok"></i> ' + response.message + '</h3>'
            );
        })
    });
})(window, document, jQuery, Backbone, formView);
