<?php

// src/Controller/ProgramController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{

    // /**

    //  * @Route("/programs/", name="program_index")

    //  */

    // public function index(): Response
    // {
    //     return $this->render('program/index.html.twig', [

    //         'website' => 'Wild Séries',
     
    //      ]);
    // }

    /**
     * @Route("/programs/{id}", methods={"GET"}, requirements={"id"="\d+"}, name="program_id")
     */

    public function showId(int $id): Response
    {
        if (is_int($id)) {
            return $this->render('program/show.html.twig', ['id' => $id]);
        } else {
            throw $this->createNotFoundException('The id does not exist');
        }
    }
}
