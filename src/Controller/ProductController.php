<?php

namespace App\Controller;

use App\Entity\Customer\Product;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product.index")
     * @return Response
     */
    public function index(): Response {

        // Product for customer01
        $product = new Product();
        $product->setName('TEST CUSTOMER01');

        $em01 = $this->getDoctrine()->getManager('customer01');
        $em01->persist($product);
        $em01->flush();

        // Product for customer02
        $product = new Product();
        $product->setName('TEST CUSTOMER02');

        $em02 = $this->getDoctrine()->getManager('customer02');
        $em02->persist($product);
        $em02->flush();

        // Read from customer01 database
        $repository01 = $em01->getRepository(Product::class, 'customer01');
        $products01 = $repository01->findBy([], [], 1);

        // Read from customer02 database
        $repository02 = $em01->getRepository(Product::class, 'customer02'); // customer02 is ignored. Can put everything, it will work.
        $products02 = $repository02->findBy([], [], 1);

        // Return records from customer01 database
        echo '<pre>'; print_r($products01); echo '</pre>';

        // Return records from customer01 database instead of customer02
        echo '<pre>'; print_r($products02); echo '</pre>';

        return new Response('');
    }

}