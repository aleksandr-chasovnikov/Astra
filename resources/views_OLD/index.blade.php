@extends('layouts.app')

@section('content')

<div class="container">
	<!-- Example row of columns -->
	<div class="row">
		<div class="content">

@if ( !empty($category) )

	@foreach ($category as $cat)
	<div class="container">
	        <h4>Категория &#8194;&#8658;&#8194; {{$cat->name_category}}</h4>
	</div>
	@endforeach

@endif

	@if (empty($articles))
		<p>Извините. В это категории ещё нет статей.</p>
	@endif

	@foreach ($articles as $article)
	
	<small class="pull-right">{{$article->created_at}}</small>
	<h3 style="font-style: italic; color: black;">{{ $article->title }}</h3>
	<br>

	<p>{{ $article->description }}</p>

		@if (!empty($article->img))
			<div class="text-center">
				<img src="uploads/{{ $article->img }}" alt="" align="middle" width="90%" />
			</div>
		@endif
	<p class="text-right"><a class="btn btn-default" href="{{ route('articleShow',['id'=>$article->id]) }}" role="button">Подробнее &raquo;</a></p>
	<hr>

	@endforeach

	<div class="paginate container">
		{{ $articles->links() }}
	</div>	


		</div>
	</div>
</div>


@endsection

