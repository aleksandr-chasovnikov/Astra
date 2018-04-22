@extends('layouts.app')

@section('content')

    <div class="container main-container">
        <div id="global-origin"></div>
        <div class="site-header image">
            <div>
                <div class="col-md-6 text-left">
                    <a href="{{ route('postCreate') }}" title="Дать бесплатное объявление">
                        <button class="btn btn-warning">
                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                            &nbsp;&nbsp;Подать объявление
                            <strong>без регистрации </strong>
                        </button>
                    </a>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('postSearchForm') }}" title="Найти свои объявления по одному из параметров">
                        <button class="btn btn-info">
                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                            &nbsp;&nbsp;Найти свои объявления
                        </button>
                    </a>
                </div>
            </div>
            <div class="clearfix">&nbsp;</div>
        </div>
        <div id="content" class="content-promo content-promo-index">
            <ul class="promo-reviews">
                <li>
                    <a href="https://vk.com/funpay" class="logo vk" title="Группа ВКонтакте"
                       rel="nofollow" target="_blank"></a>
                    <a href="{{ route('categoryIndex') }}">Категории</a>
                    <div class="count"><a href="https://vk.com/funpay" rel="nofollow"
                                          target="_blank">16 135 отзывов</a></div>
                </li>
                <li>
                    <a href="https://passport.webmoney.ru/asp/certview.asp?wmid=221291168197"
                       class="logo wmid" title="Аттестат WebMoney" rel="nofollow"
                       target="_blank"></a>
                    <div class="count"><a
                                href="https://passport.webmoney.ru/asp/certview.asp?wmid=221291168197"
                                rel="nofollow" target="_blank">0 претензий</a></div>
                </li>
                <li>
                    <a href="http://forums.goha.ru/showthread.php?t=1075287" class="logo goha"
                       title="Тема на GoHa.ru" rel="nofollow" target="_blank"></a>
                    <div class="count"><a href="http://forums.goha.ru/showthread.php?t=1075287"
                                          rel="nofollow" target="_blank">1594 отзыва</a></div>
                </li>
                <li>
                    <a href="http://www.noob-club.ru/index.php?topic=38038.0" class="logo noob"
                       title="Тема на Noob-Club.ru" rel="nofollow" target="_blank"></a>
                    <div class="count"><a href="http://www.noob-club.ru/index.php?topic=38038.0"
                                          rel="nofollow" target="_blank">439 отзывов</a></div>
                </li>
                <li>
                    <a href="http://advisor.wmtransfer.com/SiteDetails.aspx?url=funpay.ru"
                       class="logo advisor" title="WebMoney Advisor" rel="nofollow"
                       target="_blank"></a>
                    <div class="count"><a
                                href="http://advisor.wmtransfer.com/SiteDetails.aspx?url=funpay.ru"
                                rel="nofollow" target="_blank">545 отзывов</a></div>
                </li>
            </ul>

            <form action="{{--{{ route('promoFilter') }}--}}" method="post"
                  class="promo-games-filter">
                <div class="input-group">
                    <input type="text" name="query" class="form-control" placeholder="Поиск по слову или словосочетанию"
                           autocomplete="off">
                    <span class="input-group-btn">
      <button type="submit" class="btn btn-default">Найти</button>
    </span>
                </div>
            </form>

            <div class="promo-games">
                <div class="promo-games-columns">

                    @php($word = null)
                    @foreach ($categories as $category)
                        @unless ($category->parent_id)

                            <div class="promo-games-game" data-game="">
                                <p class="promo-games-title">
                                        {{ $category->title }}
                                </p>

                                <p class="promo-games-sections">
                                    @foreach ($category->subCategories() as $subCategory)
                                        <a class="
                                            @if ($loop->iteration % 2)
                                                darkorange
                                            @endif
                                                " href="{{ route('showByCategory', ['categoryId' => $subCategory->id]) }}">
                                            {{ $subCategory->title }}
                                        </a>
                                    @endforeach
                                </p>
                            </div>

                        @endunless
                    @endforeach

                </div>
            </div>

            <!--noindex-->
            {{--<div class="chat" data-id="2" data-name="flood" data-user="0" data-tag="f1285iay"--}}
                 {{--data-bookmarks-tag="">--}}

                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">--}}
                        {{--<h3 class="panel-title"><a href="https://funpay.ru/chat/?node=flood">Общий--}}
                                {{--чат</a></h3>--}}
                    {{--</div>--}}
                    {{--<div class="panel-body">--}}
                        {{--<div class="chat-messages">--}}
                            {{--<div class="message" id="message-39352117">--}}
                                {{--<div class="head">--}}
                                    {{--<div class="user">--}}
                                        {{--<span class="fa fa-user"></span>--}}
                                        {{--<a href="https://funpay.ru/users/509203/">THEM4GAME</a>--}}
                                    {{--</div>--}}
                                    {{--<div class="time" title="30 декабря, 10:36">10:36:25</div>--}}
                                {{--</div>--}}
                                {{--<div class="body"><a href="https://funpay.ru/lots/offer?id=704269"--}}
                                                     {{--target="_blank" rel="nofollow">https://funpay.ru/lots/offer?id=704269</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="message" id="message-39352118">--}}
                                {{--<div class="body"><a href="https://funpay.ru/lots/offer?id=704269"--}}
                                                     {{--target="_blank" rel="nofollow">https://funpay.ru/lots/offer?id=704269</a>--}}
                                {{--</div>--}}
                            {{--<div class="message" id="message-39353761">--}}
                                {{--<div class="head">--}}
                                    {{--<div class="user">--}}
                                        {{--<span class="fa fa-user"></span>--}}
                                        {{--<a href="https://funpay.ru/users/97688/">ALEX895GAMER</a>--}}
                                    {{--</div>--}}
                                    {{--<div class="time" title="30 декабря, 11:00">11:00:38</div>--}}
                                {{--</div>--}}
                                {{--<div class="body">✅✅✅ Прокачка 1 — 110, альянс / орда — 1500.00--}}
                                    {{--₽<br>✅✅✅ Прокачка 100 — 110, альянс / орда — 500.00 ₽<br>✅✅✅--}}
                                    {{--Прокачка 90 — 110, альянс / орда — 800.00 ₽--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="message" id="message-39353874">--}}
                                {{--<div class="head">--}}
                                    {{--<div class="user">--}}
                                        {{--<span class="fa fa-user"></span>--}}
                                        {{--<a href="https://funpay.ru/users/362024/">AlexDvur</a></div>--}}
                                    {{--<div class="time" title="30 декабря, 11:02">11:02:27</div>--}}
                                {{--</div>--}}
                                {{--<div class="body">ПРОДАЮ 14 АККАУНТОВ С КСГО! МНОГО ТАКИХ ИГРЫ КАК--}}
                                    {{--GTA5!!!! PlayerUnknown&#039;s Battlegrounds!!!! RUST! DAYZ! DOTA--}}
                                    {{--2! ЛВЛ ДО 20!! ОТЛЕГИ ДО 300 ДНЕЙ!! ИНВЕНТАРИ ДО 2000!! !!РОДНЫЕ--}}
                                    {{--ПОЧТЫ В КОМПЛЕКТЕ! НЕ ДОРОГО!! ПИСАТЬ В ЛС!<br>ТАКЖЕ ПРОДАЮ ТОП--}}
                                    {{--АКК В ТАНКАХ!\--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="controls">--}}
                            {{--<form action="https://funpay.ru/chat/message" method="post">--}}
                                {{--<input type="hidden" name="node" value="flood">--}}
                                {{--<input type="hidden" name="last_message" value="39353874">--}}
                                {{--<div class="form-group">--}}
                                    {{--<textarea class="form-control" name="content" rows="3"--}}
                                              {{--placeholder="Введите сообщение"></textarea>--}}
                                {{--</div>--}}
                                {{--<button type="submit" class="btn btn-default">Отправить</button>--}}
                            {{--</form>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>  <!--/noindex--></div>--}}
    </div>

@endsection
