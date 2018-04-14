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
                <hr>

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input name="title" type="text" class="form-control ajax-validate required" id="title"
                           value="{{ old('title') }}">
                    <div class="print-error-msg">&nbsp;&nbsp;</div>
                </div>
                <div class="form-group">
                    <label for="categories_id">Категория</label>
                    <select name="categories_id" size="7" class="form-control required" id="categories_id">
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
                    <label for="content">Текст объявления</label>
                    <textarea name="content" rows="5" class="form-control textarea ajax-validate required" id="content"
                    >{{ old('title') }}</textarea>
                    <div class="print-error-msg">&nbsp;&nbsp;</div>
                </div>
                <div class="form-group">
                    <label for="type">Тип объявления</label>
                    <select name="type" size="2" id="type" class="required">
                        <option selected value="offer">Предложение</option>
                        <option value="demand">Спрос</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="img">Фотографии</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="500000"/>
                    <input name="img" type="file" class="form-control" id="img"
                           value="{{ old('img') }}">
                </div>
                <div class="form-group">
                    <label for="price">Цена</label>
                    <input name="price" type="text" class="form-control ajax-validate" id="price"
                           value="{{ old('price') }}">
                    <div class="print-error-msg">&nbsp;&nbsp;</div>
                </div>
                <div class="form-group">
                    <label for="user_name">Контактное лицо</label>
                    <input name="user_name" type="text" class="form-control ajax-validate" id="user_name"
                           value="{{ old('user_name') }}">
                    <div class="print-error-msg">&nbsp;&nbsp;</div>
                </div>
                <div class="form-group">
                    <label for="region">Регион</label>
                    <select name="region" size="7" class="form-control required" id="region">
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
                    <input name="city" type="text" class="form-control ajax-validate" id="city"
                           value="{{ old('city') }}">
                    <div class="print-error-msg">&nbsp;&nbsp;</div>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input name="email" type="text" class="form-control ajax-validate" id="email"
                           value="{{ old('email') }}">
                    <div class="print-error-msg">&nbsp;&nbsp;</div>
                </div>
                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input name="phone" type="text" class="form-control ajax-validate required" id="phone"
                           value="{{ old('phone') }}">
                    <div class="print-error-msg">&nbsp;&nbsp;</div>
                </div>
                <div class="form-group">
                    <label for="site">Сайт</label>
                    <input name="site" type="text" class="form-control ajax-validate" id="site"
                           value="{{ old('site') }}">
                    <div class="print-error-msg">&nbsp;&nbsp;</div>
                </div>
                <div class="form-group">
                    <label for="skype">Skype</label>
                    <input name="skype" type="text" class="form-control ajax-validate" id="skype"
                           value="{{ old('skype') }}">
                    <div class="print-error-msg">&nbsp;&nbsp;</div>
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
                    <br>
                    <input name="captcha" type="text" class="form-control ajax-validate required">
                    <div class="print-error-msg">&nbsp;&nbsp;</div>
                </div>
                <hr>

                <button type="submit" class="btn btn-primary">Опубликовать</button>

                {{ csrf_field() }}
            </form>
        </div>
    </div>

@endsection