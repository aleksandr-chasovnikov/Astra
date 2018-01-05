@extends('layouts.app')

@section('content')

<div class="container">
	<!-- Example row of columns -->
	<div class="row">
		<div class="content">

	{{--@foreach ($category as $cat)--}}
		{{--<div class="container">--}}
		        {{--<h4>Категория &#8194;&#8658;&#8194; {{$cat->name_category}}</h4>--}}
		{{--</div>--}}
	{{--@endforeach--}}

	<hr>

		@foreach ($posts as $post)

			<div class="onepost">
				<div class="sheader margb4">
					<span class="dremark">№{{ $loop->iteration }}</span>

					<a href="{{ route('postShow') }}">
						{{ $post->title }}
					</a>

					<div class="price" title="{{ $post->title }} за {{ $post->price }} рублей">
						{{ $post->price }} руб.
					</div>
				</div>

				<div class="mfont margb4 bremark">{{ $post->type }} - {{ $post->created_at }}</div>
				{{ $post->content }}<div class="clear"></div>
			</div>
			<a name="post14255836"></a>
		
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


