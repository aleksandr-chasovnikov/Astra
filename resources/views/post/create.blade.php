@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">

            @if (!empty($message))
                <div class="alert alert-danger text-center">
                    {{$message}}
                </div>
            @endif

            <form action="{{ route('postStore') }}" method="post" role="form"
                  enctype="multipart/form-data">
                <h3>Подать объявление (бесплатно и без регистрации)</h3>
                <p>Поля, обозначенные звёздочкой (&#10033;), обязательны для заполнения.</p>
                <hr>

                <div class="form-group">
                    <label for="title">Заголовок</label><span style="color: #aa4a24;"> (обязательно)</span>
                    <input name="title" type="text" class="form-control ajax-validate" id="title" required
                           value="{{ old('title') }}">
                    <div class="print-error-msg">&nbsp;&nbsp;</div>

                    @if ($errors->has('title'))
                        <div class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="categories_id">Категория</label><span style="color: #aa4a24;"> (обязательно)</span>
                    <select name="categories_id" size="7" class="form-control" id="categories_id"
                            required>
                        @foreach ($categories as $category)
                            @if ($category->parent_id)
                                <option value="{{ $category->id }}">
                                    {{ $category->title }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="content">Текст объявления</label><span style="color: #aa4a24;"> (обязательно)</span>

                    {{--@if ($errors->has('content'))--}}
                        {{--<div class="help-block">--}}
                            {{--<strong>{{ $errors->first('content') }}</strong>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    <textarea name="content" rows="7" class="form-control textarea" id="content" required
                    >{{ old('title') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="type">Тип объявления</label><span style="color: #aa4a24;"> (обязательно) </span>
                    <select name="type" size="2" id="type">
                        <option selected value="offer">Предложение</option>
                        <option value="demand">Спрос</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="img">Фотографии</label>

                    {{--@if ($errors->has('img'))--}}
                        {{--<div class="help-block">--}}
                            {{--<strong>{{ $errors->first('img') }}</strong>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    <input type="hidden" name="MAX_FILE_SIZE" value="500000"/>
                    <input name="img" type="file" class="form-control" id="img"
                           value="{{ old('img') }}">
                </div>
                <div class="form-group">
                    <label for="price">Цена</label>

                    {{--@if ($errors->has('price'))--}}
                        {{--<div class="help-block">--}}
                            {{--<strong>{{ $errors->first('price') }}</strong>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    <input name="price" type="text" class="form-control" id="price"
                           value="{{ old('price') }}">
                </div>
                <div class="form-group">
                    <label for="user_name">Контактное лицо</label>

                    {{--@if ($errors->has('user_name'))--}}
                        {{--<div class="help-block">--}}
                            {{--<strong>{{ $errors->first('user_name') }}</strong>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    <input name="user_name" type="text" class="form-control" id="user_name"
                           value="{{ old('user_name') }}">
                </div>
                <div class="form-group">
                    <label for="region">Регион</label><span style="color: #aa4a24;"> (обязательно)</span>
                    <select name="region" size="7" class="form-control" id="region"
                            required>
                        @foreach ($regions as $region)
                            <option
                                    @if (1 === $region->id)
                                    selected
                                    @endif
                                    value="{{$region->id}}">{{$region->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="city">Город</label>

                    {{--@if ($errors->has('city'))--}}
                        {{--<div class="help-block">--}}
                            {{--<strong>{{ $errors->first('city') }}</strong>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    <input name="city" type="text" class="form-control" id="city"
                           value="{{ old('city') }}">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>

                    {{--@if ($errors->has('email'))--}}
                        {{--<div class="help-block">--}}
                            {{--<strong>{{ $errors->first('email') }}</strong>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    <input name="email" type="text" class="form-control" id="email"
                           value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="phone">Телефон</label>

                    {{--@if ($errors->has('phone'))--}}
                        {{--<div class="help-block">--}}
                            {{--<strong>{{ $errors->first('phone') }}</strong>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    <input name="phone" type="text" class="form-control" id="phone"
                           value="{{ old('phone') }}">
                </div>
                <div class="form-group">
                    <label for="site">Сайт</label>

                    {{--@if ($errors->has('site'))--}}
                        {{--<div class="help-block">--}}
                            {{--<strong>{{ $errors->first('site') }}</strong>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    <input name="site" type="text" class="form-control" id="site"
                           value="{{ old('site') }}">
                </div>
                <div class="form-group">
                    <label for="skype">Skype</label>

                    {{--@if ($errors->has('skype'))--}}
                        {{--<div class="help-block">--}}
                            {{--<strong>{{ $errors->first('skype') }}</strong>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    <input name="skype" type="text" class="form-control" id="skype"
                           value="{{ old('skype') }}">
                </div>
                <div class="form-group">
                    <label for="end_lifetime">Срок размещения:</label>
                    <br>
                    <input type="radio" id="two_weeks"
                           name="end_lifetime" value="2 недели">
                    <label for="two_weeks">2 недели</label>

                    <input type="radio" id="four_weeks" checked
                           name="end_lifetime" value="4 недели">
                    <label for="four_weeks">4 недели</label>

                    <input type="radio" id="eight_weeks"
                           name="end_lifetime" value="8 недель">
                    <label for="eight_weeks">8 недель</label>
                </div>
                <hr>
                <img src="{{ asset('/uploads/captcha/' . $captchaNumber . '.jpg') }}" alt="">
                <div class="form-group">
                    <label for="captcha">Наберите код с картинки:</label>
                    <span style="color: #aa4a24;"> (обязательно)</span>

                    {{--@if ($errors->has('captcha'))--}}
                        {{--<div class="help-block">--}}
                            {{--<strong>{{ $errors->first('captcha') }}</strong>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    <br>
                    <input type="text" name="captcha">
                </div>
                <hr>

                <button type="submit" class="btn btn-primary">Опубликовать</button>

                {{ csrf_field() }}
            </form>
        </div>
    </div>

@endsection