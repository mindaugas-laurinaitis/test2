<?php

namespace App\Repository;

use App\Entity\IdentifiableInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\String\Slugger\AsciiSlugger;

abstract class AbstractRepository
{

    /**
     * @var Filesystem
     */
    protected Filesystem $fileSystem;

    /**
     * @var Finder
     */
    protected Finder $finder;

    /**
     * @var AsciiSlugger
     */
    protected AsciiSlugger $slugger;

    abstract protected function getTargetEntity(): string;

    public function __construct()
    {
        $this->fileSystem = new Filesystem();

        $this->fileSystem->mkdir(self::getBaseStorePath());

        $this->finder = new Finder();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);

        $this->slugger = new AsciiSlugger();
    }

    public function insert(IdentifiableInterface $object): void
    {
        $this->fileSystem->dumpFile($this->getPath($object->getId()), json_encode($object));
    }

    public function update(IdentifiableInterface $object): void
    {
        $this->insert($object);
    }

    public function findAll($order = []): array
    {
        $objects = [];

        try {
            $this->finder->files()->in($this->getEntityPath());
            if ($this->finder->hasResults()) {
                foreach ($this->finder as $file) {
                    $fileNameWithExtension = $file->getRelativePathname();
                    $objects[] = $this->serializer->deserialize(file_get_contents($this->getEntityPath() . '/' . $fileNameWithExtension), $this->getTargetEntity(), JsonEncoder::FORMAT);
                }
            }
            if (!empty($order)) {
                usort(
                    $objects, function ($a, $b) use ($order) {
                    $property = array_key_first($order);
                    $orderBy = $order[$property];
                    $getter = sprintf('get%s', ucfirst($property));

                    if (method_exists($a, $getter)) {
                        if ($orderBy === 'asc') {
                            return $a->{$getter}() > $b->{$getter}();
                        } else {
                            return $a->{$getter}() < $b->{$getter}();
                        }
                    }
                }
                );
            }
        } catch (DirectoryNotFoundException $directoryNotFoundException) {

        }

        return $objects;
    }

    public function find(string $id): ?object
    {
        $object = null;

        if (false !== $data = file_get_contents($this->getPath($id))) {
            $object = $this->serializer->deserialize($data, $this->getTargetEntity(), JsonEncoder::FORMAT);
        }

        return $object;
    }

    public function delete(string $id): void
    {
        $this->fileSystem->remove($this->getPath($id));
    }

    protected function getPath(string $id, $extension = '.json'): string
    {
        return $this->getEntityPath() . '/' . $id . $extension;
    }

    protected function getEntityPath(): string
    {
        return self::getBaseStorePath() . '/' . $this->slugger->slug($this->getTargetEntity());
    }

    protected static function getBaseStorePath(): string
    {
        return sys_get_temp_dir();
    }
}