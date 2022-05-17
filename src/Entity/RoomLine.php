<?php

namespace App\Entity;

use App\Repository\RoomLineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomLineRepository::class)]
class RoomLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'smallint')]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: BedType::class, inversedBy: 'roomLines')]
    #[ORM\JoinColumn(nullable: false)]
    private $bedType;

    #[ORM\ManyToOne(targetEntity: Room::class, inversedBy: 'roomLines')]
    #[ORM\JoinColumn(nullable: false)]
    private $room;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getBedType(): ?BedType
    {
        return $this->bedType;
    }

    public function setBedType(?BedType $bedType): self
    {
        $this->bedType = $bedType;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }
}
