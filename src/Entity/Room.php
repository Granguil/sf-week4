<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: RoomLine::class, orphanRemoval: true,cascade:["persist"])]
    private $roomLines;

    #[ORM\ManyToOne(targetEntity: House::class, inversedBy: 'rooms')]
    #[ORM\JoinColumn(nullable: false)]
    private $house;

    public function __construct()
    {
        $this->roomLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, RoomLine>
     */
    public function getRoomLines(): Collection
    {
        return $this->roomLines;
    }

    public function addRoomLine(RoomLine $roomLine): self
    {
        if (!$this->roomLines->contains($roomLine)) {
            $this->roomLines[] = $roomLine;
            $roomLine->setRoom($this);
        }

        return $this;
    }

    public function removeRoomLine(RoomLine $roomLine): self
    {
        if ($this->roomLines->removeElement($roomLine)) {
            // set the owning side to null (unless already changed)
            if ($roomLine->getRoom() === $this) {
                $roomLine->setRoom(null);
            }
        }

        return $this;
    }

    public function getHouse(): ?House
    {
        return $this->house;
    }

    public function setHouse(?House $house): self
    {
        $this->house = $house;

        return $this;
    }
}
