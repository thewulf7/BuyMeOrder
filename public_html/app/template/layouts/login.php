<!doctype html>
<html>
<head>

    <title><?=$title?></title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes">

    <script src="/bower_components/webcomponentsjs/webcomponents.js">
    </script>


    <link rel="import" href="/bower_components/polymer/layout.html">
    <link rel="import" href="/bower_components/polymer/polymer.html">
    <link rel="import" href="/bower_components/core-ajax/core-ajax.html">

    <link rel="import"
          href="/bower_components/core-toolbar/core-toolbar.html">
    <link rel="import"
          href="/bower_components/core-menu/core-menu.html">
    <link rel="import"
          href="/bower_components/paper-item/paper-item.html">
    <link rel="import"
          href="/bower_components/core-header-panel/core-header-panel.html">
    <link rel="import"
          href="/bower_components/core-drawer-panel/core-drawer-panel.html">
    <link rel="import"
          href="/bower_components/core-icons/core-icons.html">
    <link rel="import"
          href="/bower_components/paper-icon-button/paper-icon-button.html">
    <link rel="import"
          href="/bower_components/paper-button/paper-button.html">

    <link rel="import" href="/bower_components/core-animated-pages/core-animated-pages.html">
    <link rel="import" href="/bower_components/core-animated-pages/transitions/slide-from-right.html">


    <link rel="import" href="/bower_components/core-scaffold/core-scaffold.html">
    <link rel="import" href="/bower_components/core-icon-button/core-icon-button.html">
    <link rel="import" href="/bower_components/core-icon/core-icon.html">
    <link rel="import" href="/bower_components/flatiron-director/flatiron-director.html">
    <link rel="import" href="/bower_components/font-roboto/roboto.html">
    <link rel="import" href="/bower_components/core-field/core-field.html">
    <link rel="import" href="/bower_components/paper-input/paper-input.html">
    <link rel="import" href="/bower_components/ajax-form/ajax-form.html">
    <link rel="import" href="/bower_components/paper-dialog/paper-dialog.html">
    <link rel="import" href="/bower_components/paper-dialog/paper-action-dialog.html">
    <link rel="import" href="/app/template/polymer/paper-card/paper-card.html">
    <link rel="import" href="/bower_components/core-animation/core-animation.html">

    <link rel="stylesheet" type="text/css" href="/app/template/css/style.css"/>
</head>

<body unresolved fullbleed>
        <div layout horizontal center-center fit>
            <section style="width: 100%;max-width: 600px;">
                <a href="/" class="logo"><img src="http://i.imgur.com/MDy9e.png"/></a>
                <?php if(isset($_GET["error"])):?>
                    <b style="color:red;text-align: center;display: block;">Неправильный логин или пароль</b>
                <?php endif;?>
                <form method="post" action="/login/auth" id="loginForm">
                    <paper-input-decorator floatingLabel label="Email">
                        <input name="email" type="text" required="required"/>
                    </paper-input-decorator>

                    <paper-input-decorator floatingLabel label="Пароль">
                        <input name="password" type="password" required="required"/>
                    </paper-input-decorator>
                    <input type="submit" style="display: none"/>
                    <paper-button raised class="colored" id="loginButton">Войти</paper-button>
                </form>
            </section>
        </div>
<script>
    var form = document.querySelector('#loginForm');
    var menu = [];
    document.querySelector("#loginButton").addEventListener("click", function(){
        form.submit();
    });
</script>
</body>
</html>