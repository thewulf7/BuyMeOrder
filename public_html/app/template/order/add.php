
<form method="post" action="/order/add">
        <paper-input-decorator floatingLabel label="Название проекта">
            <input name="name"/>
        </paper-input-decorator>

        <paper-input-decorator floatingLabel label="Описание">
            <textarea name="descr"></textarea>
        </paper-input-decorator>

        <paper-input-decorator floatingLabel label="Стоимость, руб.">
            <input name="price"/>
        </paper-input-decorator>

        <paper-button raised class="colored">Создать</paper-button>
</form>