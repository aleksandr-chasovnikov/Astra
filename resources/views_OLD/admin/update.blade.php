@extends('layouts.default')

@section('content')

<div class="container">
	<div class="row">
		<form action="{{ route('articlePostUpdate') }}" method="post" role="form">
			<p>Поля, обозначенные звёздочкой (&#10033;), обязательны для заполнения.</p>

			<div class="form-group">
				<label for="id">ID</label>
				<input name="id" type="hidden" class="form-control" value="{{$article->id}}">
				<input type="numeric" class="form-control" id="id" value="{{$article->id}}" disabled>
			</div>
			<div class="form-group">
				<label for="title">Заголовок</label>&nbsp;&#10033;
				<input name="title" type="text" class="form-control" id="title" value="{{$article->title}}" required>
			</div>
			<div class="form-group">
				<label for="alias">Псевдоним</label>&nbsp;&#10033;
				<input name="alias" type="text" class="form-control" id="alias" value="{{$article->alias}}" required>
			</div>
			<div class="form-group">
				<label for="categories_id">Категория</label>&nbsp;&#10033;
				<select name="categories_id" size="3" class="form-control" id="categories_id" required>
					@foreach ($categories as $category)
					@if($article->categories_id == $category->id)
					<option selected value="{{$category->id}}">{{$category->name_category}}</option>
					@else
					<option value="{{$category->id}}">{{$category->name_category}}</option>
					@endif
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="description">Краткое описание</label>&nbsp;&#10033;
				<textarea name="description" type="text" rows="4" class="form-control" id="description" required>{{$article->description}}</textarea>
			</div>
			<div class="form-group">
				<label for="text">Полный текст</label>&nbsp;&#10033;
				<textarea name="text" type="text" rows="7" class="form-control" id="text" required>{{$article->text}}</textarea>
			</div>
			<div class="form-group">
				<label for="status">Показывать?</label>
				<select name="status" id="status">
					<option value="1">Да</option>
					<option value="0">Нет</option>
				</select>
			</div>
			<div class="form-group">
				<label for="meta_desc">Мета: описание</label>
				<input name="meta_desc" type="text" class="form-control" id="meta_desc" value="{{$article->meta_desc}}">
			</div>
			<div class="form-group">
				<label for="keywords">Мета: ключевые слова</label>
				<input name="keywords" type="text" class="form-control" id="keywords" value="{{$article->keywords}}">
			</div>
<!-- 			<div class="form-group">
				<label for="created_at">Дата создания</label>
				<input name="created_at" type="text" class="form-control" id="created_at" value="{{time()}}">
			</div>
			<div class="form-group">
				<label for="updated_at">Дата создания</label>
				<input name="updated_at" type="text" class="form-control" id="updated_at" value="{{time()}}">
			</div> -->

			<button type="submit" class="btn btn-primary">Сохранить</button>

			{{ csrf_field() }}
		</form>
	</div>
</div>

@endsection