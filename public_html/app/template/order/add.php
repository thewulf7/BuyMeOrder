<form method="post" action="/order/add" is="ajax-form">
    <paper-input-decorator floatingLabel label="Название проекта">
        <input name="data[name]" type="text" required="required"/>
    </paper-input-decorator>

    <paper-input-decorator floatingLabel label="Описание">
        <textarea name="data[descr]"></textarea>
    </paper-input-decorator>

    <paper-input-decorator floatingLabel label="Стоимость, руб.">
        <input name="data[price]" type="text" required="required" id="input_price"/>
    </paper-input-decorator>

    <input type="hidden" name="data[csrf_token]" value="<?= $params['token'] ?>"/>

    <paper-button raised class="colored" id="buttonSend">Создать</paper-button>
</form>
<script>

    (function () {
        "use strict";

        var form = document.querySelectorAll('form')[0],
            content = document.querySelectorAll('.content_loader')[0],
            scaffold = document.querySelector('#scaffold'),
            ajax = document.querySelector('#ajax');

        document.getElementById("buttonSend").addEventListener("click", function () {
            form.submit();
        });

        form.querySelector("#input_price").addEventListener("keyup", function (e) {
            var value = e.target.value;
            var re = /[^0-9\.]/gi;
            if (re.test(value)) e.target.value = value.replace(re, '');

        });

        form.addEventListener('invalid', function () {
            //fields invalid
        });

        form.addEventListener('submitting', function (event) {
            //while submitting
        });

        form.addEventListener('submitted', function (event) {
            content.innerHTML = event.detail.response;

            var price = parseFloat(form.querySelector("#input_price").value);

            if (price > 0) {
                delete cache["/order/list"];

                ajax.go();
                scaffold.closeDrawer();
            }
            document.querySelector("#dialog").toggle();
        });
    }());


</script>