@extends('layouts.app')

@section('content')

    <div class="container ads-wrapper">
        <h3 class="text-center">Категория &#8194;&#8658;&#8194; {{$subCategory->title}}</h3>
        <hr>
        <div class="row">
            <div class="content col-md-8 col-sm-8">
                <div class="catalog-filters clearfix text-center">
                    <form method="post" action="{{ route('postShowByCategory') }}" role="form">
                        {{--<div class="catalog-filters-type button-group ">--}}
                            {{--<a class="button button-origin is-active" title="Все объявления"--}}
                                {{--href="{{ route('showByCategory',--}}
                                    {{--['categoryId' => $subCategory->id, 'type' => 'all']) }}" >--}}
                                {{--Все--}}
                            {{--</a>--}}
                            {{--<a class="button button-origin is-active" title="Предложения"--}}
                                {{--href="{{ route('showByCategory',--}}
                                    {{--['categoryId' => $subCategory->id, 'type' => 0]) }}" >--}}
                                {{--Предложения--}}
                            {{--</a>--}}
                            {{--<a class="button button-origin" title="Спрос"--}}
                                {{--href="{{ route('showByCategory',--}}
                                    {{--['categoryId' => $subCategory->id, 'type' => 1]) }}">--}}
                                {{--Спрос--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        <input type="hidden" name="categoryId" value="{{ $subCategory->id }}">
                        <div class="form-group">
                            <input type="radio" id="all" @if (old('type') === 'all') checked @endif
                            name="type" value="all">
                            <label for="all">Все</label>

                            <input type="radio" id="offers" @if (old('type') === 0) checked @endif
                            name="type" value="0">
                            <label for="offers">Предложения</label>

                            <input type="radio" id="demands" @if (old('type') === 1) checked @endif
                            name="type" value="1">
                            <label for="demands">Спрос</label>
                        </div>
                        {{--<div class="catalog-filters clearfix">--}}
                            {{--<a class="button button-origin is-active" title="Все объявления"--}}
                               {{--style="margin-left: 15px;"--}}
                               {{--href="{{ route('showByCategory',--}}
                                    {{--['categoryId' => $subCategory->id, 'sort' => 'created_at']) }}" >--}}
                                {{--По дате--}}
                            {{--</a>--}}
                            {{--<a class="button button-origin is-active" title="Предложения"--}}
                               {{--href="{{ route('showByCategory',--}}
                                    {{--['categoryId' => $subCategory->id, 'sort' => 'price_asc']) }}" >--}}
                                {{--Дешевле--}}
                            {{--</a>--}}
                            {{--<a class="button button-origin" title="Спрос"--}}
                               {{--href="{{ route('showByCategory',--}}
                                    {{--['categoryId' => $subCategory->id, 'sort' => 'price']) }}">--}}
                                {{--Дороже--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        <div class="catalog-filters-sort form-select-v2">
                            <select class="js-sort-select" name="sort">
                                {{--<option selected="" data-default="1" value="101">По умолчанию</option>--}}
                                <option value="created_at"
                                        @if (old('sort') == 'created_at') selected @endif>
                                    По дате</option>
                                <option value="price_asc"
                                        @if (old('sort') == 'price_asc') selected @endif>
                                    Дешевле</option>
                                <option value="price"
                                        @if (old('sort') == 'price') selected @endif>
                                    Дороже</option>
                            </select>
                        </div>
                        <button type="submit">Обновить</button>
                        {{ csrf_field() }}
                    </form>
                    {{--<div class="catalog-filters-views button-group">--}}
                        {{--<span class="button button-origin is-active" title="Показать большие фото">--}}
                            {{--<i class="i-catalog-view i-catalog-view_gallery"></i>--}}
                            {{--<i class="fas fa-table fa-lg"></i>--}}
                        {{--</span>--}}
                        {{--<a href="" class="button button-origin" title="Выводить списком с фото" rel="nofollow">--}}
                            {{--<i class="i-catalog-view i-catalog-view_table"></i>--}}
                            {{--<i class="fas fa-list fa-lg"></i>--}}
                        {{--</a>--}}
                        {{--<a href="" class="button button-origin" title="Выводить списком без фото" rel="nofollow">--}}
                            {{--<i class="i-catalog-view i-catalog-view_list"></i>--}}
                            {{--<i class="fas fa-bars fa-lg"></i>--}}
                        {{--</a>--}}
                    {{--</div>--}}
                </div>
                {{--<div class="paginate container text-center">--}}
                    {{--{{ $posts->links() }}--}}
                {{--</div>--}}

                @foreach ($posts as $post)
                    <div class="ads">

                            @if (count($post->files) > 0)
                                <img src="{{ asset($post->files->last()->path) }}" alt="фото">
                            @else
                                <img src="uploads/no_photo.jpg" alt="фото">
                            @endif

                        <div class="ads-text"
                             title="{{ $post->title }} за {{ $post->price }} рублей">
                            <a class="title" href="{{ route('postShow', ['id' => $post->id]) }}">
                                <h4>{{ $post->title }}</h4>
                            </a>
                            <div>
                                <span class="ads-price darkorange">
                                    {{ number_format(intval($post->price), 0, '.', ' ') }} руб.
                                </span>&nbsp;
                                <span class="ads-type">
                                    @if ($post->type)
                                        Спрос
                                    @else
                                        Предложение
                                    @endif
                                </span>
                            </div>
                            <p class="ads-content">
                                {{ $post->content }}
                            </p>
                            <span class="ads-type" style="margin-top: -20px;">{{ $post->created_at }}</span>
                        </div>
                        <div class="clear"></div>
                    </div>

                    {{--<small class="pull-right">{{$post->created_at}}</small>--}}
                    {{--<h3>{{ $post->title }}</h3>--}}

                    {{--@if (!empty($post->img))--}}
                    {{--<div class="text-center">--}}
                    {{--<img src="uploads/{{ $post->img }}" alt="" align="middle" width="90%">--}}
                    {{--</div>--}}
                    {{--@endif--}}

                    {{--<p>{{ $post->description }}</p>--}}

                    {{--<p class="text-right">--}}
                    {{--<a class="btn btn-default" href="{{ route('postShow',['id'=>$post->id]) }}" role="button">--}}
                    {{--Подробнее &raquo;--}}
                    {{--</a>--}}
                    {{--</p>--}}

                    {{--<hr>--}}

                @endforeach

                <div class="paginate container text-center">
                    {{ $posts->links() }}
                </div>

                @if (empty($posts))
                    <p>Извините. В этой категории ещё нет объявлений.</p>
                @endif

            </div>
            <div class="col-md-4 col-sm-4">
                {{--@foreach ($categories as $category)--}}
                        {{--<a>Категория &#8194;&#8658;&#8194; {{$category->title}}</a>--}}
                {{--@endforeach--}}
                <h4>Похожие категории:</h4>
                @foreach ($categories as $categoryParent)
                    @if (!$categoryParent->parent_id
                        && $categoryParent->id === $subCategory->parent_id)
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
    </div>

@endsection


