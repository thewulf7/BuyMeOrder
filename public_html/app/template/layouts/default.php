<!doctype html>
<html>
<head>

    <title>unquote</title>

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
            <core-icon-button icon="refresh"></core-icon-button>
            <core-icon-button icon="add"></core-icon-button>
        </core-toolbar>

        <div layout horizontal center-center fit>
            <core-animated-pages id="pages" selected="{{route}}" valueattr="hash"
                                 transitions="slide-from-right">
                <template repeat="{{page, i in pages}}">
                    <section hash="{{page.hash}}" layout vertical center-center>
                        <div style="max-width:100%;">Загрузка...</div>
                    </section>
                </template>
            </core-animated-pages>
        </div>

    </core-scaffold>
</template>
<script src="/app/template/js/app.js">
</script>
</body>
</html>