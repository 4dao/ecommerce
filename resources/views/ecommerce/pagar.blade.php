
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pedido</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
    .order-details {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f4f4f4;
    border: 1px solid #ddd;
    border-radius: 5px;
    text-align: center;
}

.error {
    color: #ff0000;
}

.item {
    margin-bottom: 20px;
    padding: 10px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.qrcode {
    max-width: 200px;
    margin-top: 10px;
}
</style>
<body>
    <div class="order-details">
        <h1>Pagamento com pix</h1>

        @if($error)
            <p class="error">{{$error}}</p>
        @endif

        @if($response)
            {{-- <p>ID do Pedido: {{$response['id']}}</p>
            <p>Referência: {{$response['reference_id']}}</p> --}}
            <p>Data de Criação: {{$response['created_at']}}</p>

            <h2>QR Codes:</h2>
            @foreach($response['qr_codes'] as $qrCode)
                <img class="qrcode" src="{{$qrCode['links'][0]['href']}}" alt="QR Code">
            @endforeach
            <p>Valor total: R$ {{ number_format($price_total / 100, 2, ',', '.') }}</p>
            
            {{-- <h2>Dados do Cliente:</h2>
            <p>Nome: {{$response['customer']['name']}}</p>
            <p>Email: {{$response['customer']['email']}}</p>
            <p>Telefone: +{{$response['customer']['phones'][0]['country']}} {{$response['customer']['phones'][0]['area']}} {{$response['customer']['phones'][0]['number']}}</p>
             --}}
            <h2>Itens:</h2>
            @foreach($response['items'] as $item)
                <div class="item">
                        <p>Nome: {{$item['name']}}</p>
                        <p>Quantidade: {{$item['quantity']}}</p>
                        <p>Valor Unitário: R${{number_format($item['unit_amount'] / 100, 2, ',', '.')}}</p>

                </div>
            @endforeach
            
            {{-- <h2>Endereço de Entrega:</h2>
            <p>Rua: {{$response['shipping']['address']['street']}}</p>
            <p>Número: {{$response['shipping']['address']['number']}}</p>
            <p>Complemento: {{$response['shipping']['address']['complement']}}</p>
            <p>Cidade: {{$response['shipping']['address']['city']}}</p>
            <p>Estado: {{$response['shipping']['address']['region_code']}}</p>
            <p>CEP: {{$response['shipping']['address']['postal_code']}}</p> --}}
            

        @endif
    </div>
</body>
</html>
