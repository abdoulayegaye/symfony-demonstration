<?php

namespace App\Controller;

use App\Entity\Tuto;
use App\Repository\TutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TutoController extends AbstractController
{
    #[Route('/tuto-1/{id}', name: 'app_tuto1')]
    public function index1(EntityManagerInterface $entityManager, int $id): Response
    {
        $tuto = $entityManager->getRepository(Tuto::class)->find($id);

        if (!$tuto){
            throw $this->createNotFoundException(
                'No tuto found for id ' . $id
            );
        }

        return $this->render('tuto/index.html.twig', [
            'controller_name' => 'TutoController',
            'name' => $tuto->getName()
        ]);
    }

    #[Route('/tuto-2/{id}', name: 'app_tuto2')]
    public function index2(TutoRepository $tutoRepository, int $id): Response
    {
        $tuto = $tutoRepository->findOneById($id);

        if (!$tuto){
            throw $this->createNotFoundException(
                'No tuto found for id ' . $id
            );
        }

        return $this->render('tuto/index.html.twig', [
            'controller_name' => 'TutoController',
            'name' => $tuto->getName()
        ]);
    }

    #[Route('/add-tuto', name: 'create_tuto')]
    public function createTuto(EntityManagerInterface $entityManager): Response
    {
        $tuto = new Tuto();
        $tuto->setName('Tuto 1');
        $tuto->setSlug('tuto-1');
        $tuto->setSubtitle('Tuto 1');
        $tuto->setDescription('Ceci est notre premier tuto');
        $tuto->setVideo('ZzMg3kHGHs4');
        $tuto->setLink('https://getbootstrap.com/docs/5.0/components/navbar/');
        $tuto->setImage('default.png');

        $entityManager->persist($tuto);

        $entityManager->flush();

        return new Response('Saved new tuto id ' . $tuto->getId());
    }
}
