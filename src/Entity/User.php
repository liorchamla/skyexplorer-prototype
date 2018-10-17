<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Plane", inversedBy="allowedUsers")
     */
    private $allowedPlanes;

    /**
     * @ORM\Column(type="float")
     */
    private $debit;

    /**
     * @ORM\Column(type="float")
     */
    private $credit;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="teacher")
     */
    private $flights;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserCourses", mappedBy="student")
     */
    private $userCourses;

    public function getStudents()
    {
        $students = $this->flights->map(function ($flight) {
            return $flight->getStudent();
        });

        $return = [];

        foreach ($students as $student) {
            if (!array_key_exists($student->getId(), $return)) {
                $return[$student->getId()] = $student;
            }
        }

        return $return;
    }

    public function getCourses()
    {
        return $this->userCourses->map(function ($relation) {
            return $relation->getCourse();
        });
    }

    public function __construct()
    {
        $this->allowedPlanes = new ArrayCollection();
        $this->flights = new ArrayCollection();
        $this->userCourses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|Plane[]
     */
    public function getAllowedPlanes(): Collection
    {
        return $this->allowedPlanes;
    }

    public function addAllowedPlane(Plane $allowedPlane): self
    {
        if (!$this->allowedPlanes->contains($allowedPlane)) {
            $this->allowedPlanes[] = $allowedPlane;
        }

        return $this;
    }

    public function removeAllowedPlane(Plane $allowedPlane): self
    {
        if ($this->allowedPlanes->contains($allowedPlane)) {
            $this->allowedPlanes->removeElement($allowedPlane);
        }

        return $this;
    }

    public function getDebit(): ?float
    {
        return $this->debit;
    }

    public function setDebit(float $debit): self
    {
        $this->debit = $debit;

        return $this;
    }

    public function getCredit(): ?float
    {
        return $this->credit;
    }

    public function setCredit(float $credit): self
    {
        $this->credit = $credit;

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
            $flight->setTeacher($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->contains($flight)) {
            $this->flights->removeElement($flight);
            // set the owning side to null (unless already changed)
            if ($flight->getTeacher() === $this) {
                $flight->setTeacher(null);
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
            $userCourse->setStudent($this);
        }

        return $this;
    }

    public function removeUserCourse(UserCourses $userCourse): self
    {
        if ($this->userCourses->contains($userCourse)) {
            $this->userCourses->removeElement($userCourse);
            // set the owning side to null (unless already changed)
            if ($userCourse->getStudent() === $this) {
                $userCourse->setStudent(null);
            }
        }

        return $this;
    }

}
