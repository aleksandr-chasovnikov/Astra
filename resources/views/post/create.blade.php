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
                    <label for="title">Заголовок</label>&nbsp;&#10033;
                    <input name="title" type="text" class="form-control" id="title" required
                           value="{{ old('title') }}">
                </div>
                <div class="form-group">
                    <label for="categories_id">Категория</label>&nbsp;&#10033;
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
                    <label for="content">Текст объявления</label>&nbsp;&#10033;
                    <textarea name="content" rows="7" class="form-control textarea" id="content" required
                    >{{ old('title') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="type">Тип объявления</label>&nbsp;&#10033;
                    <select name="type" size="2" id="type">
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
                    <input name="price" type="text" class="form-control" id="price"
                           value="{{ old('price') }}">
                </div>
                <div class="form-group">
                    <label for="user_name">Контактное лицо</label>
                    <input name="user_name" type="text" class="form-control" id="user_name"
                           value="{{ old('user_name') }}">
                </div>
                <div class="form-group">
                    <label for="region">Регион</label>&nbsp;&#10033;
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
                    <input name="city" type="text" class="form-control" id="city"
                           value="{{ old('city') }}">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input name="email" type="text" class="form-control" id="email"
                           value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input name="phone" type="text" class="form-control" id="phone"
                           value="{{ old('phone') }}">
                </div>
                <div class="form-group">
                    <label for="site">Сайт</label>
                    <input name="site" type="text" class="form-control" id="site"
                           value="{{ old('site') }}">
                </div>
                <div class="form-group">
                    <label for="skype">Skype</label>
                    <input name="skype" type="text" class="form-control" id="skype"
                           value="{{ old('skype') }}">
                </div>
                <div class="form-group">
                    <label for="end_lifetime">Срок размещения</label>
                    <input name="end_lifetime" type="text" class="form-control" id="end_lifetime"
                           value="{{ old('end_lifetime') }}">
                </div>
                <div class="form-group">
                    <label for="code">Проверочный код</label>
                    <input name="code" type="text" class="form-control" id="code"
                           value="{{ old('code') }}">
                </div>

                <button type="submit" class="btn btn-primary">Опубликовать</button>

                {{ csrf_field() }}
            </form>
        </div>
    </div>

@endsection