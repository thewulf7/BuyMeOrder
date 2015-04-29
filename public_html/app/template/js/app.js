/**
 * Created by johnnyutkin on 28.04.15.
 */
(function() {
    "use strict";

    var DEFAULT_ROUTE = 'one';

    var template = document.querySelector('#t');
    var ajax, pages, scaffold;
    var cache = {};

    template.pages = [
        {name: 'Список заказов', hash: 'order/list', url: '/order/list'},
        {name: 'Создать заказ', hash: 'order/add', url: '/order/add'}
    ];

    template.addEventListener('template-bound', function(e) {
        scaffold = document.querySelector('#scaffold');
        ajax = document.querySelector('#ajax');
        pages = document.querySelector('#pages');

        this.route = this.route || DEFAULT_ROUTE; // Select initial route.
    });

    template.keyHandler = function(e, detail, sender) {
        // Select page by num key.
        var num = parseInt(detail.key);
        if (!isNaN(num) && num <= this.pages.length) {
            pages.selectIndex(num - 1);
            return;
        }

        switch (detail.key) {
            case 'left':
            case 'up':
                pages.selectPrevious();
                break;
            case 'right':
            case 'down':
                pages.selectNext();
                break;
            case 'space':
                detail.shift ? pages.selectPrevious() : pages.selectNext();
                break;
        }
    };

    template.menuItemSelected = function(e, detail, sender) {
        if (detail.isSelected) {

            // Need to wait one rAF so <core-ajax> has it's URL set.
            this.async(function() {
                if (!cache[ajax.url]) {
                    ajax.go();
                }

                scaffold.closeDrawer();
            });

        }
    };

    template.ajaxLoad = function(e, detail, sender) {
        e.preventDefault(); // prevent link navigation.
    };

    template.onResponse = function(e, detail, sender) {
        var article = detail.response.querySelector('body');

        var html = article.innerHTML;

        cache[ajax.url] = html; // Primitive caching by URL.

        this.injectBoundHTML(html, pages.selectedItem.firstElementChild);
    };

})();

