<form method="post" action="/order/add" is="ajax-form">
        <paper-input-decorator floatingLabel label="Название проекта">
            <input name="data[name]" type="text" required="required"/>
        </paper-input-decorator>

        <paper-input-decorator floatingLabel label="Описание">
            <textarea name="data[descr]"></textarea>
        </paper-input-decorator>

        <paper-input-decorator floatingLabel label="Стоимость, руб.">
            <input name="data[price]" type="number" required="required"/>
        </paper-input-decorator>

        <input type="hidden" name="data[csrf_token]" value="<?=$params['token']?>"/>

        <paper-button raised class="colored" id="buttonSend">Создать</paper-button>
</form>
<div id="content">
</div>
<script>

    (function() {
        var form = document.querySelectorAll('form')[0],
            content = document.getElementById('content');

        document.getElementById("buttonSend").addEventListener("click", function(){
            form.submit();
        });

        form.addEventListener('invalid', function() {
            //fields invalid
        });

        form.addEventListener('submitting', function(event) {
            //event.detail.raytest = 'foobar';
            //event.detail.color = 'blue';
        });

        form.addEventListener('submitted', function(event) {
            content.innerHTML = event.detail.response;
            var inputs = form.querySelectorAll('input');
            for(var i=0;i<(inputs.length-2);i++) {
                inputs[i].value = "";
            }
            form.querySelectorAll('textarea')[0].value="";
            document.getElementById("dialog").toggle();
        });
    }());


</script>