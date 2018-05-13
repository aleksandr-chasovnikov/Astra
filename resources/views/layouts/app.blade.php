<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{!! csrf_token() !!}" />
    <title>{{ config('app.name', 'Astra') }}</title>
    <link href="{{ asset('css/includes.css') }}" rel="stylesheet" media="all">
    {{--<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.9.0/slick/slick-theme.css"/>--}}
    <meta name="description" content="На сайте {{ config('app.name', 'Astra') }} вы можете дать объявление без регистрации и бесплатно.">
</head>
<body>

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
        <a class="navbar-brand" href="{{ url('/') }}"
            >{{-- <img src="{{ asset('images') }}" alt="{{ config('app.name', 'Astra') }}">--}}{{
                config('app.name', 'Astra') }}</a>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class=" dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                        &nbsp;Помощь <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class=""><a href="#help.html">Вопросы и ответы</a></li>
                        <li class=""><a href="#arbitrage.html">Разрешение споров</a></li>
                        <li class=""><a href="#trade/info">Правила для продавцов</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <form action="{{--{{ route('promoFilter') }}--}}" method="post"
                          class="promo-games-filter">
                        <div class="input-group">
                            <input type="text" name="query" class="form-control"
                                   placeholder="Поиск по слову или словосочетанию" autocomplete="off">
                            <span class="input-group-btn">
                      <button type="submit" class="btn btn-default">Найти</button>
                    </span>
                        </div>
                    </form>
                </li>

                @if (Auth::guest())
                    {{--<li><a href="{{ route('login') }}">--}}
                            {{--<i class="fa fa-sign-in" aria-hidden="true"></i>--}}
                            {{--&nbsp;Войти--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li><a href="{{ route('register') }}">--}}
                            {{--<i class="fa fa-registered" aria-hidden="true"></i>--}}
                            {{--&nbsp;Регистрация (необязательно)--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li><a href="#" class="vk" title="Войти через ВКонтакте">--}}
                            {{--<span class="fa fa-vk fa-lg"></span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                @else
                    @if (!Auth::guest() && isAdmin())

                        <li><a href="{{ route('categoryIndex') }}">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                &nbsp;Админ-панель
                            </a>
                        </li>
                    @endif
                        <li class="m_nav_item" id="moble_nav_item_6">
                            <a href="{{ route('logout') }}" class="link link--kumya scroll">
                                <span data-letters="Выход">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    &nbsp;Выход
                                </span>
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
            <li>Обратная связь: <a href="mailto:a@#Z.ZZru">a@#Z.ZZru</a></li>
        </ul>
        <ul class="right">
            <li><a href="#" class="vk" rel="nofollow"><i class="fa fa-vk"></i></a></li>
            <li><a href="http://forums.goha.ru/showthread.php?t=1075287" class="icon goha" rel="nofollow"></a></li>
            <li><a href="https://passport.webmoney.ru/asp/certview.asp?wmid=221291168197" class="icon wm-c" rel="nofollow"></a></li>
        </ul>
    </div>
</footer>
<button id="toTop"><i class="fa fa-arrow-up fa-2x"></i></button>

{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>--}}
<script src="{{ asset('js/vendor/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/vendor/slick.min.js') }}"></script>
<script src="{{ asset('js/check_form.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>