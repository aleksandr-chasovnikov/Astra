@extends('admin.admin_external')

@section('content')

    <section>
        <div class="container">
            <div class="admin-panel">
                <ul>
{{--                    @if ('adminIndex' !== Route::current()->getName())--}}
                        <li><a class="link" href="">Все статьи</a></li>
                    {{--@endif--}}
                    <li><a class="link" href="">Создать новую статью</a></li>
                    <br/>
                    <li><a class="link" href="">Все комментарии</a></li>
                    <li><a class="link" href="">Все категории</a></li>
                    <li><a class="link" href="">Все теги</a></li>
                    <li><a class="link" href="">Все пользователи</a></li>

                    <br/>
                </ul>

                @yield('inner_content')

            </div>

        </div>
    </section>
    <br>
    <br>
    <br>
    <br>
    <br>

@endsection