<?php

namespace App\Util;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

class PathResolver
{

    /**
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(ParameterBagInterface $params, Filesystem $filesystem)
    {
        $this->params = $params;

        $this->filesystem = $filesystem;
    }

    public function resolve(): bool
    {
        $path = $this->params->get('export_path');

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->mkdir($path);
        }
        return $this->filesystem->exists($path);
    }
}
