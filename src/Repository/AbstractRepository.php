<?php

namespace App\Repository;

use App\Entity\IdentifiableInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractRepository
{
    protected const BASE_STORE_PATH = '%kernel.root_dir%/../../var/db';

    /**
     * @var Filesystem
     */
    protected Filesystem $fileSystem;

    /**
     * @var Finder
     */
    protected Finder $finder;

    abstract protected function getTargetEntity():string;

    public function __construct()
    {
        $this->fileSystem = new Filesystem();

        $this->fileSystem->mkdir(self::BASE_STORE_PATH);

        $this->finder = new Finder();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function insert(IdentifiableInterface $object)
    {
        $this->fileSystem->dumpFile($this->getPath($object->getId()), json_encode($object));
    }

    public function update(IdentifiableInterface $object)
    {
        $this->insert($object);
    }

    public function findAll()
    {
        $this->finder->files()->in($this->getEntityPath());

        $objects = [];

        if ($this->finder->hasResults()) {
            foreach ($this->finder as $file) {
                $fileNameWithExtension = $file->getRelativePathname();
                $objects[] = $this->serializer->deserialize(file_get_contents($this->getEntityPath() . '/' . $fileNameWithExtension), $this->getTargetEntity(), JsonEncoder::FORMAT);
            }
        }

        return $objects;
    }

    public function find(string $id)
    {
        $object = null;

        if(false !== $data = file_get_contents($this->getPath($id))){
            $object = $this->serializer->deserialize($data, $this->getTargetEntity(),JsonEncoder::FORMAT);
        }

        return $object;
    }

    protected function getPath(string $id, $extension = '.json')
    {
        return $this->getEntityPath() . '/'. $id . $extension;
    }

    protected function getEntityPath()
    {
        return self::BASE_STORE_PATH . '/' . $this->getTargetEntity();
    }
}