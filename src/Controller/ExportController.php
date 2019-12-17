<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\ExportType;
use App\Service\Export\Constraints\LessThan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Message\ExportMessage;


class ExportController extends AbstractController
{
    /**
     * @Route("/", name="export")
     * @param MessageBusInterface $bus
     * @param Request $request
     * @return Response
     */
    public function index(MessageBusInterface $bus, Request $request): Response
    {

        $form = $this->createForm(ExportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Add Mapping here and possible add some additional checks
            $type  = $data['type'];
            $email = $data['email'];

            $message = new ExportMessage();
            if ($type == 'xml2') {
                $message->addConstraint(new LessThan('description', 10));
                $type = 'xml';
            }

            $message->setType($type);
            $message->addEmail($email);

            $bus->dispatch($message);

            return $this->redirectToRoute('export');
        }

        return $this->render('export/index.html.twig', [
            'exportForm' => $form->createView(),
        ]);
    }
}
