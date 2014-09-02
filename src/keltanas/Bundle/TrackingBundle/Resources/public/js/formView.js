/**
 * Serve forms and validating errors
 * @author: Nikolay Ermin <keltanas@gmail.com>
 */
(function(w, $, Backbone){
    w.formView = Backbone.View.extend({
        events: {
            'submit' : function() {
                this.$el.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: $.proxy(this.formBeforeSubmit, this),
                    success: $.proxy(this.formSuccess, this),
                    error: $.proxy(this.formAfterSubmit, this)
                });
                return false;
            }
        },
        formSuccess: function(json) {
            var el;
            this.$el.find('button').removeAttr('disabled');
            this.$el.find('.error').remove();
            //this.$el.find('.has-error').remove();
            json.form = this.el;
            if ('error' == json.status) {
                if (json.errors) {
                    for (var i in json.errors) {
                        if (json.errors[i]) {
                            el = $('#' + this.$el.attr('name') + '_' + i);
                            $('<div class="error">' + json.errors[i] + '</div>').insertAfter(el);
                            //el.parents('.form-group').addClass('has-error');
                        }
                    }
                }
                $(document).trigger('form.' + this.$el.attr('id') + '.error', json);
                this.formAfterSubmit();
            }
            if ('ok' == json.status) {
                $(document).trigger('form.' + this.$el.attr('id') + '.success', json);
                $(document).trigger('form.success', [json, this.$el]);
                this.formAfterSubmit();
            }
        },
        formBeforeSubmit: function() {
            this.$el.find('button').attr('disabled','disabled');
        },
        formAfterSubmit: function(){
            this.$el.find('button').removeAttr('disabled');
        }
    });
})(window, jQuery, Backbone);
