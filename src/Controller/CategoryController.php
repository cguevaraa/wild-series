<?php

// src/Controller/ProgramController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Category;

use App\Entity\Program;

use App\Repository\ProgramRepository;

use App\Form\CategoryType;

    // /**

    //  * @Route("/categories/", name="category_")

    //  */

class CategoryController extends AbstractController
{

    /**

     * The controller for the category add form
     * Display the form or deal with it

     *

     * @Route("/categories/new", name="new")

     */

    public function new(Request $request) : Response
    {

        // Create a new Category Object

        $category = new Category();

        // Create the associated Form

        $form = $this->createForm(CategoryType::class, $category);

        // Get data from HTTP request

        $form->handleRequest($request);

        // Was the form submitted ?

        if ($form->isSubmitted()) {

            // Deal with the submitted data

            // Get the Entity Manager

            $entityManager = $this->getDoctrine()->getManager();

            // Persist Category Object

            $entityManager->persist($category);

            // Flush the persisted object

            $entityManager->flush();

            // Finally redirect to categories list

            return $this->redirectToRoute('category_index');
        }

        // Render the form

        return $this->render('category/new.html.twig', [

            "form" => $form->createView(),

        ]);
    }

    /**
     * Show all rows from Category's Entity
     *
     * @Route("/categories/", name="category_index")
     *
     * @return Response A response instance
     */

    public function index(): Response
    {
        $categories = $this->getDoctrine()

             ->getRepository(Category::class)

             ->findAll();

        return $this->render(
            'category/index.html.twig',
            ['categories' => $categories]
        );
    }

    /**
     * @Route("/categories/{categoryName}", methods={"GET"}, name="category_show")
     */

    public function show(string $categoryName): Response
    {
        $category = $this->getDoctrine()

        ->getRepository(Category::class)

        ->findOneBy(['name' => $categoryName]);


        if (!$category) {
            throw $this->createNotFoundException(
                'No program with id : '.$categoryName.' found in categories\'s table.'
            );
        } else {
            $programs = $this->getDoctrine()

        ->getRepository(Program::class)

        ->findBy(['category' => $category->getId()], ['id' => 'DESC'], 3);
            // var_dump($programs);

            return $this->render('category/show.html.twig', [

        'programs' => $programs, 'category' => $category]);
        }
    }
}
