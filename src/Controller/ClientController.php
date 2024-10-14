<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Form\ClientSearchType;
use App\DTO\ClientSearch;
use App\Repository\ClientRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/clients', name: 'clients.index')]
    // public function index(ClientRepository $clientRepository): Response
    // {
    //     $clients= $clientRepository->findAll();
    //     // dd($clients);
    //     return $this->render('client/index.html.twig', [
    //         'clients' => $clients,
    //     ]);
    // }
    public function index(Request $request, ClientRepository $clientRepository): Response
    {
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = 3;

        $searchParams = new ClientSearch();

        $searchParams->setSurname($request->query->get('surname'));
        $searchParams->setTelephone($request->query->get('telephone'));

        // $searchParams->setHasUser($request->query->get('hasUser') === 'false');
        $searchParams->setHasUser($request->query->get('hasUser') );

        $form = $this->createForm(ClientSearchType::class, $searchParams);
        $form->handleRequest($request);

        $clients = $clientRepository->findPaginated($page, $limit, $searchParams);

        $totalClients = $clientRepository->countAll();
        $totalPages = (int) ceil($totalClients / $limit);

        return $this->render('client/index.html.twig', [
            'clients' => $clients,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'form' => $form->createView(),
        ]);
    }
    //Route par défaut
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->redirectToRoute('clients.index');
    }

    // #[Route('/clients/search', name: 'clients.search')]
    // public function search(Request $request, ClientRepository $clientRepository): Response
    // {
    //     $searchData = new ClientSearch();

    //     $form = $this->createForm(ClientSearchType::class, $searchData);

    //     $form->handleRequest($request);

    //     $clients = $clientRepository->findBySearchCriteria($searchData);

    //     return $this->render('client/search.html.twig', [
    //         'form' => $form->createView(),
    //         'clients' => $clients,
    //     ]);
    // }

    #[Route('/clients/store', name: 'clients.store', methods: ['GET', 'POST'])]
    public function store(Request $request, EntityManagerInterface $entityManager, ClientRepository $clientRepository): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifiez si le numéro de téléphone existe déjà
            $existingClient = $clientRepository->findOneBy(['telephone' => $client->getTelephone()]);
            
            if ($existingClient) {
                // Ajoutez une erreur au formulaire
                $form->addError(new FormError('Un client avec ce numéro de téléphone existe déjà.'));
            } else {
                // Si aucune duplication, persistons le client
                $client->setCreatedAt(new DateTimeImmutable());
                $client->setUpdatedAt(new DateTimeImmutable());
    
                $entityManager->persist($client);
                $entityManager->flush();
    
                return $this->redirectToRoute('clients.index');
            }
        }
    
        return $this->render('client/form.html.twig', [
            'formClient' => $form->createView(),
        ]);
    }

    //Utilisation despath variables avec {id?}
    #[Route('/clients/show/{id?}', name: 'clients.show', methods: ['GET'])]
    public function show(int $id): Response
    {
        // dd($id);
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    //Utilisation des query parents
    #[Route('/clients/search/telephone', name: 'clients.searchClientByTelephone', methods: ['GET'])]
    public function searchClientByTelephone(Request $request): Response
    {
        //$request->query->get('key') ==> $_GET['key']
        //$request->request->get('name_field') ==> $_POST['name_field']

        $telephone = $request->query->get('tel');
        dd($telephone);
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/clients/remove/{id?}', name: 'clients.remove', methods: ['GET'])]
    public function remove(int $id): Response
    {
        dd($id);
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}

