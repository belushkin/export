<?php

namespace App\MessageHandler;

use App\Entity\Job;
use App\Message\ExportMessage;
use App\Service\Export\ExportAbstract;
use App\Service\ExportFactory;
use App\Util\PathResolver;
use App\Service\Export\ExportInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

class ExportHandler implements MessageHandlerInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ExportFactory
     */
    private $exportFactory;

    /**
     * @var PathResolver
     */
    private $pathResolver;

    public function __construct(ExportFactory $factory, EntityManagerInterface $entityManager, PathResolver $pathResolver)
    {
        $this->entityManager    = $entityManager;
        $this->exportFactory    = $factory;
        $this->pathResolver     = $pathResolver;
    }

    public function __invoke(ExportMessage $message)
    {
        /* @var $engine ExportAbstract*/
        $engine = $this->exportFactory->createExportEngine($message->getType());
        $engine->setConstraints($message->getConstraints());

        $jobs   = $this->entityManager->getRepository(Job::class)->findJobs();

        assert(true === $this->pathResolver->resolve());

        $engine->export($jobs);

        //
        // send email here or submit another message for it, write logic for email sending, maybe hooks, think about it
    }

}
