<?php

namespace App\Controller\Admin;

use App\Entity\MailUser;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SendMailController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/admin/send-email', name: 'admin_send_email')]
    public function sendEmail(Request $request, MailerInterface $mailer): Response
    {
        $users = $this->doctrine->getRepository(MailUser::class)->findAll();

        if ($request->isMethod('POST')) {
            $subject = $request->request->get('subject');
            $message = $request->request->get('message');
            $selectedUsers = $request->request->get('users');

            
            if (!is_array($selectedUsers)) {
                $selectedUsers = [];
            }

            foreach ($users as $user) {
                if (in_array($user->getId(), $selectedUsers)) {
                    $email = (new Email())
                        ->from('admin@myquiz.com')
                        ->to($user->getEmail())
                        ->subject($subject)
                        ->text($message);

                    $mailer->send($email);
                }
            }

            $this->addFlash('success', 'Emails sent successfully!');
            return $this->redirectToRoute('admin_send_email');
        }

        return $this->render('admin/send_email.html.twig', [
            'users' => $users,
        ]);
    }
}