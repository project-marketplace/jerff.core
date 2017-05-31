(function (window) {
    'use strict';

    if (window.projectAjaxLoader) {
        return;
    }

    window.projectAjaxLoader = function (el) {
        this.el = $(el);
        this.el.data('html', this.el.html()).text("Загрузка... ");
    };

    window.projectAjaxLoader.prototype.success = function (isActive) {
        if (isActive) {
            this.el.html(this.el.data('html')).html(this.el.data('html'));
        } else {
            this.el.addClass('hidden').removeClass('active').html(this.el.data('html')).html(this.el.data('html'));
        }
    };

    window.projectAjaxLoader.prototype.fail = function () {
        let self = this;
        self.el.text("Не удалось загрузить страницу, попробуйте позже")
                .delay(1500)
                .queue(function (n) {
                    self.el.html(self.el.data('html'));
                    n();
                });
    };

})(window);