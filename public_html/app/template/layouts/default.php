<!doctype html>
<html>
<head>

    <title>Роспил</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes">

    <script src="/bower_components/webcomponentsjs/webcomponents.js">
    </script>


    <link rel="import" href="/app/template/polymer/init.html">

    <link rel="stylesheet" type="text/css" href="/app/template/css/style.css"/>
</head>

<body unresolved fullbleed>
<template is="auto-binding" id="t">

    <!-- Route controller. -->
    <flatiron-director route="{{route}}" autoHash></flatiron-director>

    <!-- Dynamic content controller -->
    <core-ajax id="ajax" url="{{selectedPage.page.url}}" handleAs="document"
               on-core-response="{{onResponse}}"></core-ajax>

    <core-scaffold id="scaffold">

        <nav>
            <a href="/" class="logo"><img src="http://i.imgur.com/MDy9e.png"/></a>

            <h2 style="text-align: center"><?= $USER["NAME"] ?></h2>
            <core-menu id="menu" valueattr="hash"
                       selected="{{route}}"
                       selectedModel="{{selectedPage}}"
                       on-core-select="{{menuItemSelected}}" on-click="{{ajaxLoad}}">
                <template repeat="{{page, i in pages}}">
                    <paper-item hash="{{page.hash}}" noink>
                        <core-icon icon="label{{route != page.hash ? '-outline' : ''}}"></core-icon>
                        <a href="{{page.url}}">{{page.name}}</a>
                    </paper-item>
                </template>
            </core-menu>
        </nav>
        <core-toolbar tool flex>
            <div flex>{{selectedPage.page.name}}</div>
            <core-icon-button icon="refresh" id="refresh"></core-icon-button>
            <core-button><a href="/login/logout" style="color:#fff;text-decoration: none">Выйти</a></core-button>
        </core-toolbar>

        <div layout horizontal center-center fit>
            <core-animated-pages id="pages" selected="{{route}}" valueattr="hash"
                                 transitions="slide-from-right">
                <template repeat="{{page, i in pages}}">
                    <section hash="{{page.hash}}" layout vertical center-center>
                        <div style="max-width:100%;width: 600px;">Загрузка...</div>
                    </section>
                </template>
            </core-animated-pages>
        </div>

    </core-scaffold>
</template>
<script>
    var menu = <?php getMenu();?>;
</script>
<script src="/app/template/js/app.js">
</script>
</body>
</html>