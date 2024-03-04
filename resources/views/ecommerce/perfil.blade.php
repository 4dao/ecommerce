@extends('layouts.admin')

@section('title', 'Minha conta')

@section('content')

@if(session('success'))
        <p class="msg">{{session('success')}}</p>
@endif


    <section class="admin-content">
        <form action="/store" method="post" enctype="multipart/form-data">
            @csrf
            <h2>Adicionar produto</h2>

            <input type="file" name="image">
            <input type="text" placeholder="titulo" name="title">
            <input type="text" placeholder="descrição" name="description">
            <input type="number" placeholder="Preço" name="price">
            <button type="submit">Adicionar</button>
        </form>
    </section>


@endsection