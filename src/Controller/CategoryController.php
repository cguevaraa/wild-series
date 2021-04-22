<?php

// src/Controller/ProgramController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Category;

use App\Entity\Program;

use App\Repository\ProgramRepository;

    // /**

    //  * @Route("/categories/", name="category_")

    //  */

class CategoryController extends AbstractController
{
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
