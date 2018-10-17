<?php

namespace App\Controller;

use App\Repository\FlightRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index()
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    /**
     * @Route("/login", name="account_login")
     *
     * @return void
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('account/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout()
    {}

    /**
     * @Route("/", name="account_flights")
     *
     * @param FlightRepository $repo
     * @return void
     */
    public function myFlights(FlightRepository $repo, AuthorizationCheckerInterface $auth)
    {
        if ($auth->isGranted('ROLE_TEACHER')) {
            return $this->render('account/flights-teacher.html.twig', [
                'flights' => $repo->findBy(['teacher' => $this->getUser()], ['day' => 'DESC']),
            ]);
        } else {
            return $this->render('account/flights.html.twig', [
                'flights' => $repo->findBy(["student" => $this->getUser()], ['day' => 'DESC']),
            ]);
        }
    }
}
