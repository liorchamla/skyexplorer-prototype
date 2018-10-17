<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FlightRepository")
 */
class Flight
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plane", inversedBy="flights")
     */
    private $plane;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="flights")
     */
    private $teacher;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="flights")
     */
    private $student;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $flightTime;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $floorTime;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $escale;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isFlightBook;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isLPE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paymentType;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPaid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $escaleLocation;

    /**
     * @ORM\Column(type="time")
     */
    private $startAt;

    /**
     * @ORM\Column(type="time")
     */
    private $endAt;

    /**
     * @ORM\Column(type="date")
     */
    private $day;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $fuel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Course", inversedBy="flights")
     */
    private $course;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlane(): ?Plane
    {
        return $this->plane;
    }

    public function setPlane(?Plane $plane): self
    {
        $this->plane = $plane;

        return $this;
    }

    public function getTeacher(): ?User
    {
        return $this->teacher;
    }

    public function setTeacher(?User $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getStudent(): ?User
    {
        return $this->student;
    }

    public function setStudent(?User $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getFlightTime(): ?float
    {
        return $this->flightTime;
    }

    public function setFlightTime(float $flightTime): self
    {
        $this->flightTime = $flightTime;

        return $this;
    }

    public function getFloorTime(): ?float
    {
        return $this->floorTime;
    }

    public function setFloorTime(float $floorTime): self
    {
        $this->floorTime = $floorTime;

        return $this;
    }

    public function getEscale(): ?bool
    {
        return $this->escale;
    }

    public function setEscale(bool $escale): self
    {
        $this->escale = $escale;

        return $this;
    }

    public function getIsFlightBook(): ?bool
    {
        return $this->isFlightBook;
    }

    public function setIsFlightBook(bool $isFlightBook): self
    {
        $this->isFlightBook = $isFlightBook;

        return $this;
    }

    public function getIsLPE(): ?bool
    {
        return $this->isLPE;
    }

    public function setIsLPE(bool $isLPE): self
    {
        $this->isLPE = $isLPE;

        return $this;
    }

    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    public function setPaymentType(string $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getEscaleLocation(): ?string
    {
        return $this->escaleLocation;
    }

    public function setEscaleLocation(string $escaleLocation): self
    {
        $this->escaleLocation = $escaleLocation;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getDay(): ?\DateTimeInterface
    {
        return $this->day;
    }

    public function setDay(\DateTimeInterface $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getFuel(): ?float
    {
        return $this->fuel;
    }

    public function setFuel(?float $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }

}
