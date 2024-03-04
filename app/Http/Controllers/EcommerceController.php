<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\OrderItems;
use App\Models\Orders;
use DateInterval;
use DateTime;
use DateTimeZone;
use PagSeguro\Configuration\Configure;


class EcommerceController extends Controller
{
    private $_configs;

    public function index()
    {
        $product = Products::orderBy('id', 'desc')->get();
        $user = auth()->user();
        if ($user) {
            $carrinho = $user->orderitems;
            return view('welcome', ['product' => $product, 'car' => $carrinho]);
        }

        return view('welcome', ['product' => $product]);
    }

    public function store(Request $request)
    {
        $product = new Products();

        $product->name = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;

        // upload de imagem
        if ($request->hasFile('image')) {
            $requestimage = $request->image;

            $extension = $requestimage->extension();

            $imagename = md5($requestimage->getClientOriginalName() . strtotime('now')) . '.' . $extension;

            $request->image->move(public_path('imagem/product'), $imagename);

            $product->image = $imagename;
        }

        $product->save();

        return back()->with('success', 'produto adicionado com sucesso.');
    }

    public function car(Request $request, $id)
    {

        // Recupera o produto do banco de dados
        $product = Products::find($id);
        $user = auth()->user();

        if (!$product) {
            return back()->with('error', 'Produto não encontrado');
        }

        // Tenta encontrar um item do carrinho relacionado ao produto
        // $car = OrderItems::where('product_id', $product->id)->first();
        $cartItems = OrderItems::where('user_id', $user->id)->get();

        foreach ($cartItems as $cartItem) {
            if ($cartItem->product_id === $product->id) {
                // Se o produto já estiver no carrinho, aumenta a quantidade
                $cartItem->quantity += 1;
                $cartItem->save();

                return back()->with('success', 'Quantidade adicionada ao item no carrinho');
            }
        }


        // Se o item do carrinho não existir, cria um novo
        $cartItems = new OrderItems();


        $cartItems->user_id = $user->id;
        $cartItems->quantity = 1;
        $cartItems->product_id = $product->id;
        $cartItems->price = $product->price;

        $cartItems->save();

        return back()->with('success', 'Produto adicionado ao carrinho com sucesso');
    }

    public function finish()
    {

        $user = auth()->user();
        $car = $user->orderitems;
        $serial = md5(time() . rand(0, 9999) . time());

        if (count($car) > 0) {
            foreach ($car as $item) {

                $order = new Orders();
                $order->user_id = $user->id;
                $order->product_id = $item->product_id;
                $order->status = 'Aguardando pagamento';
                $order->quantity = $item->quantity;
                $order->serial = $serial;

                $order->save();

                $car->each->delete();
            };
            return redirect("/pagar/$order->serial");
            // return back()->with('success', 'Compra realizada. Aguardando pagamento!');
        } else {
            return back()->with('error', 'Sem items no carrinho');
        }
    }
    // public function finish()
    // {
    //     $user = auth()->user();
    //     $cartItems = $user->orderItems;

    //     if ($cartItems->isNotEmpty()) {
    //         foreach ($cartItems as $item) {
    //             $order = new Order();
    //             $order->user_id = $user->id;
    //             $order->product_id = $item->product_id;
    //             $order->status = 'Aguardando pagamento';

    //             // Adicione outros campos conforme necessário

    //             $order->save();
    //         }

    //         // Limpar o carrinho (remover itens associados ao pedido)
    //         $cartItems->each->delete();

    //         return back()->with('success', 'Compra realizada. Aguardando pagamento!');
    //     } else {
    //         return back()->with('error', 'Sem itens no carrinho');
    //     }
    // }


    public function purchase()
    {
        $user = auth()->user();

        $carrinho = $user->orderitems;

        $order = $user->order()->orderBy('serial')->get();

        if ($order) {
            return view('ecommerce.purchase', ['orders' => $order, 'car' => $carrinho]);
        }
    }


    public function pagar($serial)
    {
        $token_pagseguro = env('PAGSEGURO_TOKEN');


        $endpoint = 'https://api.pagseguro.com/orders';
        $token = $token_pagseguro;
        $user = auth()->user();

        $orders = $user->order()->where('serial', $serial)->get();
        $firstOrder = $orders->first();


        $carItems = [];

        $date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $date->add(new DateInterval('PT30M'));
        $formattedDate = $date->format('Y-m-d\TH:i:sP');
        $price_total = 0;

        foreach ($orders as $item) {

            $price_item = $item->product->price * $item->quantity;

            $carItems[] = [
                "name" => $item->product->name,
                "quantity" => $item->quantity, // Defina a quantidade conforme necessário
                "unit_amount" => $item->product->price // Defina o valor unitário conforme necessário
            ];

            $price_total += $price_item;
        }

        $body =
            [
                "reference_id" => $firstOrder->serial,
                "customer" => [
                    "name" => $user->name,
                    "email" => "c69251714082937429528@sandbox.pagseguro.com.br",
                    "tax_id" => "12345678909",
                    "phones" => [
                        [
                            "country" => "55",
                            "area" => "11",
                            "number" => "999999999",
                            "type" => "MOBILE"
                        ]
                    ]
                ],
                "items" => $carItems,
                "qr_codes" => [
                    [
                        "amount" => [
                            "value" => $price_total
                        ],
                        "expiration_date" => $formattedDate,
                    ]
                ],
                "shipping" => [
                    "address" => [
                        "street" => "Avenida Brigadeiro Faria Lima",
                        "number" => "1384",
                        "complement" => "apto 12",
                        "locality" => "Pinheiros",
                        "city" => "São Paulo",
                        "region_code" => "SP",
                        "country" => "BRA",
                        "postal_code" => "01452002"
                    ]
                ],
                "notification_urls" => [
                    "https://alexandrecardoso-pagseguro.ultrahook.com"
                ]
            ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_CAINFO, "cacert.pem");
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization: Bearer ' . $token
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            var_dump($error);
            die();
        }

        $data = json_decode($response, true);

        dd($data);
        return view('ecommerce.pagar', ['response' => $data, 'error' => $error, 'price_total' => $price_total]);
    }
}
