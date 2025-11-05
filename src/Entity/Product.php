<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
readonly class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid', unique: true)]
    public string $uuid;

    #[ORM\Column(length: 20)]
    public string $barcode;

    #[ORM\Column(length: 50)]
    public string $store;

    #[ORM\Column(type: 'json')]
    public array $data;

    #[ORM\Column(type: 'datetime_immutable')]
    public DateTimeImmutable $createdAt;

    public function __construct(
        string $barcode,
        string $store,
        array $data
    ) {
        $this->uuid = Uuid::uuid4()->toString();
        $this->barcode = $barcode;
        $this->store = $store;
        $this->data = $data;
        $this->createdAt = new DateTimeImmutable();
    }
}
