@extends('layouts.main')

@section('title', 'Privat-e commerce')

@section('content')

@php
    $userId = auth()->id();
@endphp
@if(session('success'))
<p class="msg">{{session('success')}}</p>
@endif

@if(session('error'))
<p class="msg msgerror">{{session('error')}}</p>
@endif

    <!-- Seção de Destaques -->
    {{-- <section class="container mt-4">
        <h2 class="section-title">Destaques</h2>
        <!-- Adicione o conteúdo da seção de destaques aqui -->
    </section> --}}

    <!-- Seção de Produtos -->

    <section class="container mt-4">
        <h2 class="section-title">Nossos Produtos</h2>
        <div class="row">

           @foreach ($product as $item) 
             <div class="col-md-4 mb-4">
                 <div class="card">
                     <img src="imagem/product/{{$item->image}}" class="card-img-top" alt="Produto 1">
                     <div class="card-body">
                         <h5 class="card-title">{{$item->name}}</h5>
                         <p class="card-text">{{$item->description}}</p>
                         <p class="card-text"><strong>R$ R${{number_format($item->price / 100, 2, ',', '.')}}</p></strong></p>
                         <a href="/car/{{$item->id}}" class="btn btn-primary">Adicionar ao Carrinho</a>
                     </div>
                 </div>
             </div>
           @endforeach


            <!-- Adicione mais blocos de produtos conforme necessário -->
        </div>
    </section>

@endsection