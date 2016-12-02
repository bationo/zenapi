<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SubCategoryController extends Controller
{
    /**
     * @Route("/", name="subcategories")
     */
    public function listAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository("AdminBundle:SubCategory")->findByCategorySlugWithPosts("affairage");

        return $this->render('subcategory/list.html.twig', array(
            'categories' => $categories,
        ));
    }
}
