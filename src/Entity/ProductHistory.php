<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use App\Entity\User;

#[ORM\Entity]
#[ORM\Table(name: 'product_history')]
readonly class ProductHistory
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid', unique: true)]
    public string $uuid;

    #[ORM\Column(length: 20)]
    public string $barcode;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'uuid', nullable: false)]
    public User $user;

    #[ORM\Column(type: 'datetime_immutable')]
    public DateTimeImmutable $createdAt;

    public function __construct(string $barcode, User $user)
    {
        $this->uuid = Uuid::uuid4()->toString();
        $this->barcode = $barcode;
        $this->user = $user;
        $this->createdAt = new DateTimeImmutable();
    }
}
