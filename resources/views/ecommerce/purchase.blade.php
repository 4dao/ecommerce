@extends('layouts.main')


@section('title', 'Minhas Compras')


@section('content')
<section class="container mt-4">
    <h2 class="section-title">Minhas Compras </h2>

    @if ($orders->isNotEmpty())
        @php
            $currentSerial = null;
        @endphp

        @foreach ($orders as $order)
            @if ($order->serial != $currentSerial)
                @if ($currentSerial !== null)
                    </div>
                @endif

                <p>Compras com Serial: {{ $order->serial }}</p>
                @if ($order->status == "Aguardando pagamento") 
                    <a style="margin-bottom: 10px" class="btn btn-primary" href="/pagar/{{$order->serial}}">Realizar Pagamento</a>
                @endif
                <div class="row">
            @endif

            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="imagem/product/{{ $order->product->image }}" class="card-img-top" alt="Produto 1">
                    <div class="card-body">
                        <p class="card-text" style="font-size: 12px">Quantidade: {{$order->quantity}}</p>
                        <h5 class="card-title">{{ $order->product->name }}</h5>
                        <p class="card-text" style="color: green">{{ $order->status }}</p>
                        <p class="card-text"><strong>R$ {{ $order->product->price }}</strong></p>
                    </div>
                </div>
            </div>

            @php
                $currentSerial = $order->serial;
            @endphp
        @endforeach

        </div> <!-- Fechar a última div.row -->
    @else
        <p>Você ainda não fez nenhuma compra.</p>
    @endif
</section>


@endsection