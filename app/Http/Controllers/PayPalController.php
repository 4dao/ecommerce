<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class PayPalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        // Configurar o contexto da API do PayPal
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('services.paypal.client_id'),
                config('services.paypal.secret')
            )
        );
        $this->apiContext->setConfig(config('services.paypal.settings'));
    }

    public function checkout()
    {
                // Recupere o usuário autenticado
                $user = auth()->user();

                // Crie um pagamento do PayPal
                $payment = $this->createPayment($user);
        
                // Redirecione para a URL de aprovação do PayPal
                return Redirect::to($payment->getApprovalLink());
    }

    public function success()
    {
        // Implemente a lógica para o sucesso do pagamento aqui
    }

    public function cancel()
    {
        // Implemente a lógica para o cancelamento do pagamento aqui
    }
}
