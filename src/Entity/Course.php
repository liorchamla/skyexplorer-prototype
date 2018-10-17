<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 */
class Course
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="float")
     */
    private $flightTime;

    /**
     * @ORM\Column(type="float")
     */
    private $floorTime;

    /**
     * @ORM\Column(type="float")
     */
    private $briefingTime;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     */
    private $flightHourPrice;

    /**
     * @ORM\Column(type="float")
     */
    private $floorHourPrice;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Plane", mappedBy="courses")
     */
    private $planes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="course")
     */
    private $flights;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserCourses", mappedBy="course")
     */
    private $userCourses;

    public function getTime()
    {
        return $this->flightTime + $this->floorTime + $this->briefingTime;
    }

    public function __construct()
    {
        $this->planes = new ArrayCollection();
        $this->flights = new ArrayCollection();
        $this->userCourses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getBriefingTime(): ?float
    {
        return $this->briefingTime;
    }

    public function setBriefingTime(float $briefingTime): self
    {
        $this->briefingTime = $briefingTime;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFlightHourPrice(): ?float
    {
        return $this->flightHourPrice;
    }

    public function setFlightHourPrice(float $flightHourPrice): self
    {
        $this->flightHourPrice = $flightHourPrice;

        return $this;
    }

    public function getFloorHourPrice(): ?float
    {
        return $this->floorHourPrice;
    }

    public function setFloorHourPrice(float $floorHourPrice): self
    {
        $this->floorHourPrice = $floorHourPrice;

        return $this;
    }

    /**
     * @return Collection|Plane[]
     */
    public function getPlanes(): Collection
    {
        return $this->planes;
    }

    public function addPlane(Plane $plane): self
    {
        if (!$this->planes->contains($plane)) {
            $this->planes[] = $plane;
            $plane->addCourse($this);
        }

        return $this;
    }

    public function removePlane(Plane $plane): self
    {
        if ($this->planes->contains($plane)) {
            $this->planes->removeElement($plane);
            $plane->removeCourse($this);
        }

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    public function addFlight(Flight $flight): self
    {
        if (!$this->flights->contains($flight)) {
            $this->flights[] = $flight;
            $flight->setCourse($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->contains($flight)) {
            $this->flights->removeElement($flight);
            // set the owning side to null (unless already changed)
            if ($flight->getCourse() === $this) {
                $flight->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserCourses[]
     */
    public function getUserCourses(): Collection
    {
        return $this->userCourses;
    }

    public function addUserCourse(UserCourses $userCourse): self
    {
        if (!$this->userCourses->contains($userCourse)) {
            $this->userCourses[] = $userCourse;
            $userCourse->setCourse($this);
        }

        return $this;
    }

    public function removeUserCourse(UserCourses $userCourse): self
    {
        if ($this->userCourses->contains($userCourse)) {
            $this->userCourses->removeElement($userCourse);
            // set the owning side to null (unless already changed)
            if ($userCourse->getCourse() === $this) {
                $userCourse->setCourse(null);
            }
        }

        return $this;
    }
}
