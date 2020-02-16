<?php

namespace App\Entity;

use App\Traits\JsonSerializeTrait;
use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;
use DateTime;

class Subscriber implements IdentifiableInterface, JsonSerializable
{
    use JsonSerializeTrait;

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
     * @Assert\Email()
     */
    private $email;

    /**
     * @var array
     */
    private $categories = [];

    /**
     * @var DateTime 
     */
    private $createdAt;

    public function __construct()
    {
        $this->id = uuid_create(UUID_TYPE_RANDOM);
        $this->createdAt = new DateTime();
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
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param array $categories
     *
     * @return Subscriber
     */
    public function setCategories(array $categories): Subscriber
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     *
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }
}
