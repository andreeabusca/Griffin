<?php

namespace App\Controller;
use App\Entity\Account;
use App\Entity\Transaction;
use App\Form\TransactionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class TransactionController extends AbstractController
{
    #[Route('/transaction', name: 'app_transaction')]
    public function index(): Response
    {
        return $this->render('transaction/index.html.twig', [
            'controller_name' => 'TransactionController',
        ]);
    }

    #[Route('/make_transaction/{id}', name:'app_make_transaction')]
    public function make_transaction(#[MapEntity(id: 'id')]Account $account, Request $request, EntityManagerInterface $em): Response{

        $transaction = new Transaction();
        $transaction->setSenderAccount($account);
        $transaction->setTransactionDate(new \DateTimeImmutable());
        $transaction->setStatus('Pending');
        $transaction->setFeeAmount('0.0000');
        
        $date = $transaction->getTransactionDate()->format('Ymd');
        $letters = '';
        for($i =0; $i < 4; $i++){
            $letters.= chr(random_int(65,90));
        }

        $transaction->setReferenceNumber($date . $letters);

        $form = $this->createForm(TransactionFormType::class, $transaction);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
         if ($account->getBalance() < $transaction->getAmount()) {
            $this->addFlash('error', 'Insufficient funds.');
            return $this->redirectToRoute('app_client');
        }
         if ($account == $transaction->getReceiverAccount()) {
            $this->addFlash('error', 'Same account.');
            return $this->redirectToRoute('app_client');
        }

        $sender = $transaction->getSenderAccount();
        $receiver = $transaction->getReceiverAccount();

         if ($sender->getAccountStatus() !== 'Active' || $receiver->getAccountStatus() !== 'Active') {
            $this->addFlash('error', 'Transaction cannot be performed: one or both accounts are inactive.');
            return $this->redirectToRoute('app_client');
        }


        $amount = $transaction->getAmount();
        
        $sender->setBalance($sender->getBalance() - $amount);
        $receiver->setBalance($receiver->getBalance() + $amount);

        $em->persist($sender);
        $em->persist($receiver);
        $em->persist($transaction);
        $em->flush();

         return $this->redirectToRoute('app_client');
    }

    return $this->render('transaction/make_transaction.html.twig', [
        'form' => $form,
        'account' => $account
    ]);
    }

    #[Route('/transactions', name: 'app_transactions')]
    #[IsGranted('ROLE_ADMIN')]
    public function view_transactions(EntityManagerInterface $em):Response
    {
        $transactions= $em->getRepository(Transaction::class)->findBy([],['transactionDate' => 'DESC']);
        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactions,
        ]);
    }
}
