<?php

namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;

class Subscriber implements IdentifiableInterface, JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @var string
     */
    private $category;

    public function __construct()
    {
        $this->id = uuid_create(UUID_TYPE_RANDOM);
    }

    /**
     * @param string $id
     *
     * @return Subscriber
     */
    public function setId(string $id): Subscriber
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Subscriber
     */
    public function setName(string $name): Subscriber
    {
        $this->name = $name;

        return $this;
    }

    /**
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Subscriber
     */
    public function setEmail(string $email): Subscriber
    {
        $this->email = $email;

        return $this;
    }

    /**
     *
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     *
     * @return Subscriber
     */
    public function setCategory(?string $category): Subscriber
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $data = [];

        foreach ($this as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }
}
