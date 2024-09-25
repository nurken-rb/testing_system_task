<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return new Response('aaaaaaaaaaaaaaaa');
    }
}