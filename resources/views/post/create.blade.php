@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">

        <form action="{{ route('postStore') }}" method="post" role="form"
              enctype="multipart/form-data">
            <h3>Подать объявление (без регистрации)</h3>
            <hr>

            @if (!empty($message))
                <div class="alert alert-success text-center">
                    {{$message}}
                    <a href="{{ route('postShow', ['id' => $postId]) }}">Ссылка на созданное объявление.</a>
                </div>
            @endif

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
                <label for="region_id">Регион</label>
                <select name="region_id" class="form-control addPost required" id="region_id">
                    {{--<option value="none" selected="selected">Обязательное поле</option>--}}
                    @foreach ($regions as $region)
                        <option @if (old('region_id') == $region->id) selected @endif
                        value="{{$region->id}}">{{$region->name}}</option>
                    @endforeach
                </select>
                <div class="print-error-msg">&nbsp;&nbsp;</div>
            </div>
            <div class="form-group">
                <label for="type">Тип объявления </label>
                <br>
                <select name="type" size="2" id="type" class="form-control addPost required">
                    <option @if (old('type') == 0) selected @endif
                    value="0">Предложение</option>
                    <option @if (old('type') == 1) selected @endif
                    value="1">Спрос</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="category_id">Категория</label>
                <select name="category_id" class="form-control addPost required" id="category_id">
                    {{--<option value="none">Обязательное поле</option>--}}
                    @php($styleColor = null)
                    @foreach ($categories as $categoryParent)
                        @if (!$categoryParent->parent_id)
                            <optgroup label="{{ $categoryParent->title }}">
                                @foreach ($categories as $category)
                                    @if ($categoryParent->id === $category->parent_id)
                                        <option @if (old('category_id') == $category->id) selected @endif
                                        value="{{ $category->id }}">
                                            {{ $category->title }}
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup>
                        @endif
                    @endforeach
                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="title">Заголовок</label><a name="title"></a>
                <span class="countChars"></span>
                <input name="title" type="text" maxlength="{{ $titleMaxLength or 120 }}"
                       class="form-control ajax-validate required" id="title"
                       value="{{ old('title') }}" data-name="Заголовок">
                <div class="print-error-msg">&nbsp;&nbsp;</div>
            </div>
            <div class="form-group">
                <label for="content">Текст объявления
                    <span style="color: #999; font-weight: 100">(обязательно)</span>
                </label><a name="content"></a>
                <span class="countChars"></span>
                <textarea name="content" rows="5"  maxlength="{{ $contentMaxLength or 1800 }}"
                          class="form-control textarea ajax-validate" required id="content"
                          data-name="Текст_объявления">{{ old('content') }}</textarea>
                <div class="print-error-msg">&nbsp;&nbsp;</div>
            </div>
            <div class="form-group">
                <label for="price">Цена (в рублях)</label><a name="price"></a>
                <span class="countChars"></span>
                <input name="price" type="text"  maxlength="{{ $priceMaxLength or 20 }}"
                       class="form-control ajax-validate" id="price"
                       value="{{ old('price') or 0 }}" data-name="Цена">
                <div class="print-error-msg">&nbsp;&nbsp;</div>
            </div>
            <div class="form-group">
                <label for="user_name">Контактное лицо</label><a name="user_name"></a>
                <span class="countChars"></span>
                <input name="user_name" type="text" maxlength="{{ $titleMaxLength or 120 }}"
                       class="form-control ajax-validate" id="user_name"
                       value="{{ old('user_name') }}" data-name="Контактное_лицо">
                <div class="print-error-msg">&nbsp;&nbsp;</div>
            </div>
            <div class="form-group">
                <label for="city">Город</label><a name="city"></a>
                <span class="countChars"></span>
                <input name="city" type="text" maxlength="{{ $titleMaxLength or 120 }}"
                       class="form-control ajax-validate" id="city"
                       value="{{ old('city') }}" data-name="Город">
                <div class="print-error-msg">&nbsp;&nbsp;</div>
            </div>
            <div class="form-group">
                <label for="email">E-mail
                    <a title="Ваш email будет надежно защищен от спама">
                        &#128274;
                    </a>
                </label><a name="email"></a>
                <span class="countChars"></span>
                <input name="email" type="text" maxlength="{{ $titleMaxLength or 120 }}"
                       class="form-control ajax-validate" id="email"
                       value="{{ old('email') }}" data-name="E-mail">
                <div class="print-error-msg">&nbsp;&nbsp;</div>
            </div>
            <div class="form-group">
                <label for="phone">Телефон</label><a name="phone"></a>
                <span class="countChars"></span>
                <input name="phone" type="text" maxlength="{{ $priceMaxLength or 25 }}"
                       class="form-control ajax-validate required" id="phone"
                       value="{{ old('phone') }}" data-name="Телефон">
                <div class="print-error-msg">&nbsp;&nbsp;</div>
            </div>
            <div class="form-group">
                <label for="photo">Фотографии
                    <span style="font-weight: 100">
                        (максимальный размер 5Мб)
                    </span>
                </label>
                <input type="hidden" name="MAX_FILE_SIZE" value="{{ \App\Http\Requests\StorePostRequest::MAX_FILE_SIZE }}"/>
                <input name="photo[]" type="file" class="form-control" id="photo"
                       value="{{ old('photo') }}" multiple>
                <br>
                <a class="btn btn-info btn-sm js-addPhoto">&#10010; Ещё фотографии</a>
            </div>
            <div class="form-group">
                <label for="site">Сайт</label><a name="site"></a>
                <span class="countChars"></span>
                <input name="site" type="text"  maxlength="{{ $titleMaxLength or 120 }}"
                       class="form-control ajax-validate" id="site"
                       value="{{ old('site') }}" data-name="Сайт">
                <div class="print-error-msg">&nbsp;&nbsp;</div>
            </div>
            <div class="form-group">
                <label for="skype">Skype</label><a name="skype"></a>
                <span class="countChars"></span>
                <input name="skype" type="text" maxlength="{{ $titleMaxLength or 120 }}"
                       class="form-control ajax-validate" id="skype"
                       value="{{ old('skype') }}" data-name="Skype">
                <div class="print-error-msg">&nbsp;&nbsp;</div>
            </div>
            <div class="form-group">
                <label for="end_lifetime">Срок размещения:</label>
                <br>
                <input type="radio" id="two_weeks" @if (old('end_lifetime') == 0) checked @endif
                name="end_lifetime" value="0">
                <label for="two_weeks">2 недели</label>

                <input type="radio" id="four_weeks" @if (old('end_lifetime') == 1) checked @endif
                name="end_lifetime" value="1">
                <label for="four_weeks">4 недели</label>

                <input type="radio" id="eight_weeks" @if (old('end_lifetime') == 2) checked @endif
                name="end_lifetime" value="2">
                <label for="eight_weeks">8 недель</label>
            </div>
            <hr>
            <img src="{{ asset('/uploads/captcha/' . $captchaImage . '.jpg') }}" alt="">
            <div class="form-group">
                <label for="captcha">Наберите код с картинки:</label><a name="captcha"></a>

                <input name="captcha" id="captcha" type="text" class="form-control ajax-validate required"
                       data-name="Наберите код с картинки" data-captcha="{{ $captchaImage }}">
                <div class="print-error-msg">&nbsp;&nbsp;</div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">Опубликовать</button>
            {{ csrf_field() }}
        </form>
    </div>
</div>

@endsection