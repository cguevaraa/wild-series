<?php

// src/Controller/ProgramController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use App\Entity\Program;

use App\Entity\Season;

use App\Entity\Episode;

    // /**

    //  * @Route("/programs/", name="program_")

    //  */

class ProgramController extends AbstractController
{

    /**
     * Show all rows from Program's Entity
     *
     * @Route("/programs/", name="index")
     *
     * @return Response A response instance
     */

    public function index(): Response
    {
        $programs = $this->getDoctrine()

             ->getRepository(Program::class)

             ->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    /**
     * @Route("/programs/{id}", methods={"GET"}, requirements={"id"="\d+"}, name="program_id")
     */

    public function show(Program $program): Response
    {
        // $program = $this->getDoctrine()

        // ->getRepository(Program::class)

        // ->findOneBy(['id' => $id]);




        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$program.' found in program\'s table.'
            );
        }

        $seasons = $program->getSeasons();

        return $this->render('program/show.html.twig', [

        'program' => $program,

        'seasons' => $seasons,

        ]);
    }

    /**
     * @Route("/programs/{programId}/seasons/{seasonId}", methods={"GET"}, requirements={"programId"="\d+"}, name="program_season_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId": "id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"seasonId": "id"}})
     */

    public function showSeason(Program $program, Season $season)
    {
        // // Get the program passed as parameter
        // $program = $this->getDoctrine()

        // ->getRepository(Program::class)

        // ->findOneBy(['id' => $programId]);

        // //Get the season associated
        // $season = $this->getDoctrine()

        // ->getRepository(Season::class)

        // ->findOneBy(['program' => $programId]);


        //Get the episodes from the selected season
        $episodes = $this->getDoctrine()

        ->getRepository(Episode::class)

        ->findBy(['season' => $season->getId()]);

        //var_dump($episodes);

        return $this->render('program/season_show.html.twig', [

            'program' => $program,
    
            'season' => $season,

            'episodes' => $episodes,
    
            ]);
    }

    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
    }
}
