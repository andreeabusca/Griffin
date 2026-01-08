<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    #[Route('/create_accout', name:'app_create_account')]
    public function create_account(Request $request, EntityManagerInterface $em): Response
    {
        $client = $this->getUser();

        $account = new Account();
        $account->setClient($client);         
        $account->setAccountStatus('Active');
        $account->setBalance('0.0000');

        $form = $this->createForm(AccountFormType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($account);
            $em->flush();

            $this->addFlash('success', 'Account created successfully!');

            return $this->redirectToRoute('app_client');
        }

        return $this->render('account/create_account.html.twig', [
            'accountForm' => $form,
        ]);
        }

    #[Route('delete_account/{id}', name: 'app_delete_account', methods: ['POST'])]
    public function delete_account(Request $request, Account $account, EntityManagerInterface $em): RedirectResponse{
        $user = $this->getUser();

        if($account->getClient() !== $user){
            throw $this->createAccessDeniedException('You cannot delete this account.');
        }

        $token = $request->request->get('_token');
         if ($this->isCsrfTokenValid('delete_account_' . $account->getId(), $token)) {
            $em->remove($account);
            $em->flush();
            $this->addFlash('success', 'Account deleted successfully.');
        } else {
            $this->addFlash('error', 'Invalid CSRF token.');
        }

        return $this->redirectToRoute('app_client');
    }
}
