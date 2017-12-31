@extends('layouts.app')

@section('content')

<section>
    <div class="container">
        <div class="admin-panel">
            <ul>
                <li><a href="{{route('articleCreate')}}">Добавить новую статью</a></li>
            <br>
        <!--         <li><a href="{{route('categoryIndex')}}">Управление категориями</a></li>
            <br> -->
            </ul>

            @foreach($articles as $article)

                <hr>
                <small class="pull-right">{{$article->created_at}}</small>     
                <h2>{{ $article->title }}</h2>
                <p>{{ $article->description }}</p>
                <p>
                    <a class="btn btn-default" href="{{ route('articleShow',['id'=>$article->id]) }}" role="button">Подробнее &raquo;</a>
                    <a class="btn btn-warning" href="{{ route('articleUpdate',['id'=>$article->id]) }}" role="button">Редактировать</a>
                </p>                
                <br>            
                <form action="{{ route('articleDelete', ['post'=>$article->id]) }}" method="post">
                    <!-- <input type="hidden" name="_method" value="DELETE"> -->
                    {{method_field('DELETE')}}
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form> 

            @endforeach

        </div>

    </div>
</section>

@endsection