<?php

namespace App\Controller;

use App\Entity\Menus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MenusController extends AbstractController
{

    public function __invoke(Request $request, Menus $data)
    {
        $content = json_decode($request->getContent());
        $data->setNom($content->nom);
        

    }
}
