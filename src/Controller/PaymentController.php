<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="payment")
     */
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }

    #Test this endpoint stripe by hitting it.; exp: localhost:8000/checkout
    /**
     * @Route("/checkout", name="payment")
     */
    public function checkout($stripSK): Response
    {
        Stripe::setApiKey($stripSK);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'T-shirt',
                    ],
                    'unit_amount' => 2000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'https://master.d275v0hfacbx1p.amplifyapp.com/landingPage',
            'cancel_url' => 'https://master.d275v0hfacbx1p.amplifyapp.com/landingPage',
        ]);
        echo json_encode(array('client_secret' => $session->client_secret));
        #dd($session);
        return $this->redirect($session->url, 303);

        #$response = new Response();
        #$response->setContent(json_encode(array('url' => $session->url)));
// the headers public attribute is a ResponseHeaderBag
        #$response->headers->set('Content-Type', 'application/json');

        #$response->setStatusCode(200);
        #return $response->send();

    }
}
