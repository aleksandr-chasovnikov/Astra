@extends('layouts.app')

@section('content')

    <div class="container ads-wrapper">
        <!-- Example row of columns -->
        <div class="row">
            <div class="content">

                {{--@foreach ($category as $cat)--}}
                {{--<div class="container">--}}
                {{--<h4>Категория &#8194;&#8658;&#8194; {{$cat->name_category}}</h4>--}}
                {{--</div>--}}
                {{--@endforeach--}}

                @foreach ($posts as $post)

                    {{--<span class="dremark">№{{ $loop->iteration }}</span>--}}
                    <div class="ads">
                        <img src="{{asset('uploads/no_photo.jpg')}}" alt="фото">
                        <div class="ads-text"
                             title="{{ $post->title }} за {{ $post->price }} рублей">
                            <a class="title" href="{{ route('postShow', ['id' => $post->id]) }}">
                                <h4>{{ $post->title }}</h4>
                            </a>
                            <div>
                                <span class="ads-price">{{ number_format(intval($post->price), 0, '.', ' ') }} руб.</span>&nbsp;
                                <span class="ads-type">
                                    @if ($post->type)
                                        Спрос
                                    @else
                                        Предложение
                                    @endif
                                    -- {{ $post->created_at }}
                                </span>
                            </div>
                            <p class="ads-content">
                                {{ $post->content }}
                            </p>
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

                <div class="paginate container">
                    {{ $posts->links() }}
                </div>

                @if (empty($post))

                    <p>Извините. В этой категории ещё нет объявлений.</p>

                @endif

            </div>
        </div>
    </div>


@endsection


