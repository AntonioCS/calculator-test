<?php

namespace App\Controller;

use App\Calculator\Calculator;
use App\Form\CalculatorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CalculatorController extends AbstractController
{
    /**
     * @Route("/", name="calculator")
     */
    public function index(Request $request)
    {
        $result = null;
        $form = $this->createForm(CalculatorType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $calc = new Calculator();
            $result = $calc->calculate($data['formula']);
        }

        return $this->render('calculator/index.html.twig', [
            'form' => $form->createView(),
            'result' => $result
        ]);
    }
}
