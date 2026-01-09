<?php

namespace App\Controller;
use App\Entity\Client;
use App\Form\ClientFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    #[IsGranted('ROLE_USER')]
    public function dashboard()
    {
        $client= $this->getUser();
        $accounts = $client->getAccounts();
        return $this->render('client/client.html.twig', [
            'client' => $client,
            'accounts' => $accounts,
        ]);
    }

    #[Route('/client/profile', name: 'app_profile')]
    #[IsGranted('ROLE_USER')]
    public function profile(Request $request, EntityManagerInterface $em): Response
    {
        $client = $this->getUser();

        $form = $this->createForm(ClientFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('client/profile.html.twig', [
            'client' => $client,
            'profileForm' => $form,
        ]);
    }

    #[Route('/admin', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function admin_dashboard()
    {
        $admin= $this->getUser();
        return $this->render('client/admin.html.twig', [
            'admin' => $admin,
        ]);
    }

    #[Route('/clients', name: 'app_clients')]
    #[IsGranted('ROLE_ADMIN')]
    public function view_clients(EntityManagerInterface $em):Response
    {
        $clients= $em->getRepository(Client::class)->findAll();
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);
    }

}
