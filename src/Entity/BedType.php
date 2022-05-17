<?php

namespace App\Entity;

use App\Repository\BedTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BedTypeRepository::class)]
class BedType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'smallint')]
    private $place;

    #[ORM\Column(type: 'string', length: 255)]
    private $size;

    #[ORM\OneToMany(mappedBy: 'bedType', targetEntity: RoomLine::class, orphanRemoval: true)]
    private $roomLines;

    public function __construct()
    {
        $this->roomLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(int $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

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
            $roomLine->setBedType($this);
        }

        return $this;
    }

    public function removeRoomLine(RoomLine $roomLine): self
    {
        if ($this->roomLines->removeElement($roomLine)) {
            // set the owning side to null (unless already changed)
            if ($roomLine->getBedType() === $this) {
                $roomLine->setBedType(null);
            }
        }

        return $this;
    }
}
