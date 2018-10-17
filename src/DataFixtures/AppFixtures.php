<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\Flight;
use App\Entity\Plane;
use App\Entity\User;
use App\Entity\UserCourses;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = Factory::create('fr_FR');
    }

    private function getRoundPrice($start, $end, $step)
    {
        return $this->faker->randomElement(range($start, $end, $step));
    }

    public function load(ObjectManager $manager)
    {
        $slugger = new Slugify();

        $planesDef = [
            ['title' => 'Piper Pa-28 Arrow 4 Turbo', 'type' => 'F-GGCF'],
            ['title' => 'Piper Pa-28 Cherokee', 'type' => 'F-GGBQ'],
            ['title' => 'Piper Pa-28 Archer 2 181', 'type' => 'F-GCTQ'],
            ['title' => 'Piper Pa-28 Cherokee', 'type' => 'F-HAAU'],
            ['title' => 'Piper Pa-28 Arrow 2', 'type' => 'F-GJCS'],
        ];

        $coursesDef = [
            ['title' => 'LAPL', 'flight' => 30, 'floor' => 52, 'briefing' => 1, 'flightPrice' => $this->getRoundPrice(25, 75, 10), 'floorPrice' => $this->getRoundPrice(25, 75, 10), 'price' => $this->getRoundPrice(10000, 20000, 1000)],
            ['title' => 'PPL', 'flight' => 45, 'floor' => 52, 'briefing' => 10, 'flightPrice' => $this->getRoundPrice(25, 75, 10), 'floorPrice' => $this->getRoundPrice(25, 75, 10), 'price' => $this->getRoundPrice(20000, 30000, 5000)],
            ['title' => 'CPL', 'flight' => 25, 'floor' => 30, 'briefing' => 10, 'flightPrice' => $this->getRoundPrice(25, 75, 10), 'floorPrice' => $this->getRoundPrice(25, 75, 10), 'price' => $this->getRoundPrice(10000, 20000, 1000)],
        ];

        $planes = [];
        $teachers = [];
        $students = [];
        $courses = [];
        $flights = [];

        $admin = new User();
        $admin->setEmail('lchamla@gmail.com')
            ->setPassword($this->encoder->encodePassword($admin, 'pass'))
            ->setFirstName('Lior')
            ->setLastName('Chamla')
            ->setPhone('0622747039')
            ->setDebit(0)
            ->setCredit(0)
            ->setRoles(['ROLE_ADMIN', 'ROLE_TEACHER']);
        $manager->persist($admin);

        foreach ($coursesDef as $courseDef) {
            $course = new Course();
            $course->setTitle($courseDef['title'])
                ->setSlug($slugger->slugify($courseDef['title']))
                ->setFlightTime($courseDef['flight'])
                ->setFloorTime($courseDef['floor'])
                ->setFlightHourPrice($courseDef['flightPrice'])
                ->setFloorHourPrice($courseDef['floorPrice'])
                ->setPrice($courseDef['price'])
                ->setBriefingTime($courseDef['briefing']);

            $manager->persist($course);

            $courses[] = $course;
        }

        foreach ($planesDef as $planeDef) {
            $plane = new Plane();
            $plane->setTitle($planeDef['title'])
                ->setSlug($slugger->slugify($planeDef['title']))
                ->setRentalPrice($this->faker->randomElement(range(10, 25, 3)) * 10)
                ->setType($planeDef['type'])
                ->setModel('');

            foreach ($this->faker->randomElements($courses) as $course) {
                $plane->addCourse($course);
            }

            $manager->persist($plane);
            $planes[] = $plane;
        }

        for ($i = 0; $i < 5; $i++) {
            $gender = mt_rand(0, 1) ? 'male' : 'female';

            $teacher = new User();
            $teacher->setCredit(0)
                ->setDebit(0)
                ->setEmail($this->faker->email)
                ->setFirstName($this->faker->firstname($gender))
                ->setLastName($this->faker->lastname)
                ->setPassword($this->encoder->encodePassword($teacher, 'pass'))
                ->setPhone($this->faker->e164PhoneNumber)
                ->setRoles(['ROLE_TEACHER']);

            $manager->persist($teacher);
            $teachers[] = $teacher;
        }

        for ($i = 0; $i < 30; $i++) {
            $student = new User();

            $gender = mt_rand(0, 1) ? 'male' : 'female';

            $student->setFirstName($this->faker->firstname($gender))
                ->setLastName($this->faker->lastname)
                ->setEmail($this->faker->email)
                ->setPassword($this->encoder->encodePassword($student, 'password'))
                ->setRoles(['ROLE_STUDENT'])
                ->setPhone($this->faker->e164PhoneNumber)
                ->setCredit(mt_rand(0, 2000))
                ->setDebit(mt_rand(0, 1000));

            foreach ($this->faker->randomElements($courses, mt_rand(1, 2)) as $course) {
                $userCourse = new UserCourses();
                $userCourse->setStudent($student)
                    ->setCourse($course);

                $manager->persist($userCourse);

                for ($j = 0; $j < mt_rand(1, 10); $j++) {
                    $flight = new Flight();
                    $day = $this->faker->dateTimeBetween('-6 months');
                    $startAt = $this->getRoundPrice(9, 15, 1);
                    $endAt = $startAt + mt_rand(1, 3);

                    $flightTime = $this->getRoundPrice(1, $endAt - $startAt, 1);
                    $floorTime = $endAt - $startAt === 0 ? 0 : $endAt - $startAt - $flightTime;

                    $startAt = (clone $day)->setTime($startAt, 0);
                    $endAt = (clone $day)->setTime($endAt, 0);

                    $flight->setStudent($student)
                        ->setDay($this->faker->dateTimeBetween('-6 months'))
                        ->setStartAt($startAt)
                        ->setEndAt($endAt)
                        ->setPlane($this->faker->randomElement($planes))
                        ->setFlightTime($flightTime)
                        ->setFloorTime($floorTime)
                        ->setEscale(true)
                        ->setEscaleLocation($this->faker->city)
                        ->setFuel($this->getRoundPrice(100, 300, 5))
                        ->setIsPaid((bool) mt_rand(0, 1))
                        ->setIsLPE((bool) mt_rand(0, 1))
                        ->setIsFlightBook((bool) mt_rand(0, 1))
                        ->setPaymentType($this->faker->randomElement(['CHQ', 'VISA', 'ESPECES', 'VIREMENT']))
                        ->setTeacher($this->faker->randomElement($teachers))
                        ->setCourse($course);

                    $manager->persist($flight);
                }
            }

            $manager->persist($student);
        }

        $manager->flush();
    }
}
