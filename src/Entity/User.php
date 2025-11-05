<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
readonly class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid', unique: true)]
    public string $uuid;

    #[ORM\Column(length: 100, unique: true)]
    public string $email;

    #[ORM\Column(length: 255)]
    public string $password;

    #[ORM\Column(length: 50)]
    public string $name;

    #[ORM\Column(type: 'datetime_immutable')]
    public DateTimeImmutable $createdAt;

    #[ORM\Column(length: 20)]
    public string $status;

    public function __construct(
        string $email,
        string $password,
        string $name,
        string $status,

    ) {
        $this->uuid = Uuid::uuid4()->toString();
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->status = $status;
        $this->createdAt = new DateTimeImmutable();
    }
}
