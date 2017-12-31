<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Astra') }}</title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('css/fontawesome/fontawesome-all.css') }}" rel="stylesheet" media="all">
    {{--<script src="https://funpay.ru/180/js/jquery.min.js"></script>--}}
    {{--<script src="https://funpay.ru/180/js/bootstrap.min.js"></script>--}}
    {{--<script src="https://funpay.ru/180/js/main.min.js"></script>--}}
    <meta name="description" content="На сайте {{ config('app.name', 'Astra') }} вы можете дать объявление без регистрации и бесплатно.">
    {{--<script type="application/ld+json">[{"@context":"http:\/\/schema.org\/","@type":"WebSite","name":"FunPay","url":"https:\/\/funpay.ru\/"}]</script>--}}
</head>
<body>
<!--suppress ALL -->

{{--<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TWG83B"--}}
                  {{--height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>--}}
{{--<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':--}}
        {{--new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],--}}
        {{--j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=--}}
        {{--'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);--}}
    {{--})(window,document,'script','dataLayer','GTM-TWG83B');</script>--}}

{{--<script>--}}
    {{--(function (d, w, c) {--}}
        {{--(w[c] = w[c] || []).push(function() {--}}
            {{--try {--}}
                {{--w.yaCounter36956765 = new Ya.Metrika({--}}
                    {{--id:36956765,--}}
                    {{--clickmap:true,--}}
                    {{--trackLinks:true,--}}
                    {{--accurateTrackBounce:true,--}}
                    {{--ut:"noindex",--}}
                    {{--ecommerce:"dataLayer"--}}
                {{--});--}}
            {{--} catch(e) { }--}}
        {{--});--}}

        {{--var n = d.getElementsByTagName("script")[0],--}}
            {{--s = d.createElement("script"),--}}
            {{--f = function () { n.parentNode.insertBefore(s, n); };--}}
        {{--s.type = "text/javascript";--}}
        {{--s.async = true;--}}
        {{--s.src = "https://mc.yandex.ru/metrika/watch.js";--}}

        {{--if (w.opera == "[object Opera]") {--}}
            {{--d.addEventListener("DOMContentLoaded", f, false);--}}
        {{--} else { f(); }--}}
    {{--})(document, window, "yandex_metrika_callbacks");--}}
{{--</script>--}}
{{--<noscript>--}}
    {{--<div>--}}
        {{--<img src="https://mc.yandex.ru/watch/36956765?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div>--}}
{{--</noscript>--}}
<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}"><img src="/img/layout/logo.svg" alt="{{ config('app.name', 'Astra') }}"></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class=" dropdown">
                    <a href="https://funpay.ru/" class="dropdown-toggle" data-toggle="dropdown">Помощь <span class="caret"></span></a>                              <ul class="dropdown-menu">
                        <li class=""><a href="https://funpay.ru/help.html">Вопросы и ответы</a></li>
                        <li class=""><a href="https://funpay.ru/arbitrage.html">Разрешение споров</a></li>
                        <li class=""><a href="https://funpay.ru/trade/info">Правила для продавцов</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

                @if (Auth::guest())

                    <li><a href="{{ route('login') }}">Войти</a></li>
                    <li><a href="{{ route('register') }}">Регистрация (необязательно)</a></li>
                    <li><a href="#" class="vk" title="Войти через ВКонтакте">
                            <span class="fa fa-vk fa-lg"></span>
                        </a>
                    </li>

                @else

                    @if (isAdmin())

                        <li><a href="{{ route('categoryIndex') }}">Админ-панель</a></li>

                    @endif

                        <li class="m_nav_item" id="moble_nav_item_6">
                            <a href="{{ route('logout') }}" class="link link--kumya scroll">
                                <span data-letters="Выход">Выход</span>
                            </a>
                        </li>
                @endif
            </ul>
        </div>
    </div>
</div>

@yield('content')

<footer class="main-footer">
    <div class="container">
        <ul class="left">
            <li>
                <a href="{{ route('contact') }}">© {{ config('app.name') }}</a>, 2017
                @if (date('Y', time()) > 2017)
                    - {!! date('Y', time()) !!}
                @endif
                .
                Все права защищены.</li>
            <li>Обратная связь: <a href="mailto:a@funpayZ.ZZru">a@funpayZ.ZZru</a></li>
        </ul>
        <ul class="right">
            <li><a href="https://vk.com/funpay" class="vk" rel="nofollow"><i class="fa fa-vk"></i></a></li>
            <li><a href="http://forums.goha.ru/showthread.php?t=1075287" class="icon goha" rel="nofollow"></a></li>
            <li><a href="https://passport.webmoney.ru/asp/certview.asp?wmid=221291168197" class="icon wm-c" rel="nofollow"></a></li>
        </ul>
    </div>
</footer>
<!--suppress JSUndeclaredVariable, JSUnresolvedVariable -->
{{--<script>--}}
    {{--window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=--}}
        {{--d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.--}}
    {{--_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");--}}
        {{--$.src="//v2.zopim.com/?2uAvJ6SRQuF3VGUB6rQpq3RHW4HAi1Cs";z.t=+new Date;$.--}}
            {{--type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");--}}
{{--</script>--}}
</body>
</html>