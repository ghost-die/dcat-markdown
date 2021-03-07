(function (w, $) {

    function ExtensionDropzone(options) {
        var element = $("#"+options.id);
        this.options = $.extend({
            $el: element,
        }, options);

        this.init(this.options);
    }

    ExtensionDropzone.prototype = {
        init: function (options) {
            // imageUploadURL

            options.parser = function (e) {
                let parser = new HyperDown();
                return parser.makeHtml(e);
            }
            options.$el.markdown(options);


            Dropzone.autoDiscover = false;

            //图片上传
            new Dropzone("#"+options.id, {
                url: options.imageUploadURL,
                clickable: false,//to be clickable to select files
                // addRemoveLinks: true,
                method: 'post',
                filesizeBase: 1024,
                headers: {
                    'X-CSRF-Token': Dcat.token
                },
                success: function (file, response, e) {
                    if (response){
                        let html = options.$el.val();
                        html += '\n' + '![输入图片说明](' + response.location + ' "在这里输入图片标题")';
                        options.$el.val(html);
                    }
                }
            });
        },
    };

    $.fn.extensionDropzone = function (options) {
        options = options || {};
        options.$el = $(this);

        return new ExtensionDropzone(options);
    };
})(window, jQuery);