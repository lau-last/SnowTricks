<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class SendMail
{


    /**
     * @throws TransportExceptionInterface
     */
    public function send(MailerInterface $mailer, string $userEmail, string $template, array $context): void
    {
        $email = (new TemplatedEmail())
            ->from('no-reply@snowtricks.oc')
            ->to($userEmail)
            ->subject('Security SnowTricks')
            ->htmlTemplate($template)
            ->context($context);

        $mailer->send($email);
    }


}