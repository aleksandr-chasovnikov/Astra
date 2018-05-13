@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="content col-md-9 col-sm-9">
                @if($post)
                <div class="content">
                    <h4>{{ $post->title }}</h4>
                    <p>Тип: {{ $post->type }}</p>
                    <p>Просмотров: {{ $post->viewed or 0 }}</p>
                    @if (!empty($post->price))
                        <p>Цена: {{ $post->price }}</p>
                    @endif
                    @if (!empty($post->content))
                        <p> {{ $post->content }}</p>
                    @endif
                    @if (!empty($post->phone))
                        <p>Телефон: {{ $post->phone }}</p>
                    @endif
                    @if (!empty($post->user_name))
                        <p>Контактное лицо: {{ $post->user_name }}</p>
                    @endif
                    @if (!empty($post->city))
                        <p>Город: {{ $post->city }}</p>
                    @endif
                    @if (!empty($post->email))
                        <p>Сайт: {{ $post->email }}</p>
                    @endif
                    @if (!empty($post->site))
                        <p>Сайт: {{ $post->site }}</p>
                    @endif
                    @if (!empty($post->skype))
                        <p>Skype: {{ $post->skype }}</p>
                    @endif
                    @if (!empty($post->created_at))
                        <p>Создано: {{ $post->created_at }}</p>
                    @endif

                </div>
                <div class="owl-carousel owl-theme">
                    @if (empty($post->files))
                        <div><img src="{{ asset('images/no_photo.jpg') }}" alt="photo" /></div>
                    @endif

                    @foreach($post->files as $photo)
                        <div><img class="image-slider" src="{{ asset($photo->path) }}" alt="фото"></div>
                    @endforeach
                </div>
                    {{--@foreach($post->files as $photo)--}}
                        {{--<img class="image-sub-slider" src="{{ asset($photo->path) }}" alt="фото">--}}
                    {{--@endforeach--}}
                    <hr>
                    {{-- Комментарии: --}}

                    {{--@foreach($comments as $comment)--}}
                    {{--<div class="content">--}}
                    {{--<h2>{{ $comment->user_name }}</h2>--}}
                    {{--<p>{{ $comment->created_at }}</p>--}}
                    {{--<p>{{ $comment->comm }}</p>--}}
                    {{--<!-- <a class="btn btn-default" href="#" role="button">Ответить</a> -->--}}

                    {{--@if ((Auth::check()) && ((Auth::user()->email) == $comment->user_email	|| (Auth::user()->role) == 'admin'))--}}
                    {{--<form action="{{ route('commentDelete', ['comment'=>$comment->id]) }}" method="post">--}}
                    {{--<!-- <input type="hidden" name="_method" value="DELETE"> -->--}}
                    {{--{{method_field('DELETE')}}--}}
                    {{--{{csrf_field()}}--}}
                    {{--<button type="submit" class="btn btn-danger">Удалить</button>--}}
                    {{--</form>--}}
                    {{--@endif --}}
                    {{--<hr>--}}
                    {{--</div>--}}
                    {{----}}
                    {{--@endforeach--}}

                    {{--<form action="{{ route('commentStore') }}" class="content" method="post"--}}
                    {{--role="form">--}}
                    {{--<h3>Добавить комментарий</h3>--}}

                    {{--<input type="hidden" name="article_id" value="{{ $post->id }}">--}}
                    {{--<textarea name="comm" id="comm" rows="4" class="form-control"--}}
                    {{--placeholder="Введите свой комментарий" required></textarea>--}}

                    {{--@if(Auth::check())--}}
                    {{--<input type="hidden" name="user_email" value="{{ Auth::user()->email }}">--}}
                    {{--<input type="hidden" name="user_name" value="{{ Auth::user()->name }}">--}}
                    {{--@else--}}
                    {{--<input class="form-control" name="user_email" type="email"--}}
                    {{--placeholder="E-mail (обязательно)" required>--}}
                    {{--<input class="form-control" name="user_name" type="text"--}}
                    {{--placeholder="Имя (обязательно)" required>--}}
                    {{--@endif--}}
                    {{--{{ csrf_field() }}--}}

                    {{--<button class="btn btn-default" type="submit">Отправить комментарий</button>--}}
                    {{--</form>--}}

                @endif

            </div>
            <div class="col-md-3 col-sm-3">
                {{--@foreach ($categories as $category)--}}
                {{--<a>Категория &#8194;&#8658;&#8194; {{$category->title}}</a>--}}
                {{--@endforeach--}}
                <h4>Похожие категории:</h4>
                @foreach ($categories as $categoryParent)
                    @if (!$categoryParent->parent_id
                        && $categoryParent->id === $post->category->parent_id)
                        <ul>
                            @foreach ($categories as $category)
                                @if ($categoryParent->id === $category->parent_id)
                                    <li>
                                        <a href="{{ route('showByCategory', ['categoryId' => $category->id]) }}">
                                            {{ $category->title }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </div>
        </div>

        {{--@if (Auth::check() && (Auth::user()->role == 'admin'))--}}
        {{--<form class="form-horizontal" role="form" method="POST" action="{{ route('upload') }}"--}}
        {{--enctype="multipart/form-data">--}}
        {{--{{ csrf_field() }}--}}
        {{--<div class="form-group">--}}
        {{--<label for="file" class="col-md-4 control-label">Загрузить файл</label>--}}
        {{--<div class="col-md-6">--}}
        {{--<input name="id" type="hidden" class="form-control" value="{{$post->id}}">--}}
        {{--<input id="file" type="file" class="form-control" name="file" required>--}}
        {{--<button type="submit" class="btn btn-info">Загрузить</button>--}}
        {{--</div>--}}
        {{--</form>--}}
        {{--<hr>--}}
        {{--<form class="form-horizontal" role="form" method="POST" action="{{ route('upload') }}"--}}
        {{--enctype="multipart/form-data">--}}
        {{--{{ csrf_field() }}--}}
        {{--<div class="form-group">--}}
        {{--<label for="file" class="col-md-4 control-label">Удалить изображение</label>--}}
        {{--<div class="col-md-6">--}}
        {{--<input name="id" type="hidden" class="form-control" value="{{$post->id}}">--}}
        {{--<button type="submit" class="btn btn-info">Удалить</button>--}}
        {{--</div>--}}
        {{--</form>--}}
        {{--@endif--}}
    </div>

@endsection


