/**
 * Created by johnnyutkin on 28.04.15.
 */

(function () {
    "use strict";

    var DEFAULT_ROUTE = 'order/list';
    var APP_NAME = document.querySelector("title").innerText;

    var template = document.querySelector('#t');
    var ajax, pages, scaffold;
    var cache = {};


    template.pages = menu;

    template.addEventListener('template-bound', function (e) {
        scaffold = document.querySelector('#scaffold');
        ajax = document.querySelector('#ajax');
        pages = document.querySelector('#pages');

        this.route = this.route || DEFAULT_ROUTE; // Select initial route.
    });

    template.menuItemSelected = function (e, detail, sender) {
        if (detail.isSelected) {

            // Need to wait one rAF so <core-ajax> has it's URL set.
            this.async(function () {
                if (!cache[ajax.url]) {
                    ajax.go();
                }
                scaffold.closeDrawer();
            });
            document.querySelector("title").innerText = APP_NAME + " - " + detail.item.innerText;

        }
    };

    template.ajaxLoad = function (e, detail, sender) {
        e.preventDefault(); // prevent link navigation.
    };

    template.onResponse = function (e, detail, sender) {
        var article = detail.response.querySelector('body');

        var html = article.innerHTML;

        cache[ajax.url] = html; // primitive caching by url

        this.injectBoundHTML(html, pages.selectedItem.firstElementChild);

        var refresh = document.querySelector("#refresh");

        refresh.addEventListener("click", function () {
            ajax.go();
            scaffold.closeDrawer();
        });
    };

})();

