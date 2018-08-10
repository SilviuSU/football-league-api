<?php

namespace AppBundle\Controller;

use AppBundle\Validation\UserValidator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Services\UserService;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $service;

    /**
     * @param UserService $userService
     *
     * @internal param UserService $leagueService
     */
    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    /**
     *
     * @Route("/user/", methods={"POST"})
     *
     * @param Request $request
     * @param UserValidator $validator
     * @param UserPasswordEncoder $encoder
     *
     * @return JsonResponse
     */
    public function createAction(Request $request, UserValidator $validator, UserPasswordEncoder $encoder)
    {
        try {
            $request = $validator->isValid($request);

            $email = $request["email"];
            $password = $request["password"];
            $role = $request["role"];

            $this->service->create($email, $password, $role, $encoder);

            return new JsonResponse(
                [],
                200
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                500
            );
        }
    }

    /**
     * @Route("/user/{email}/{password}", name="token_authentication", methods={"GET"})
     *
     * @param Request $request
     * @param UserPasswordEncoder $encoder
     *
     * @return JsonResponse
     */
    public function getTokenAction(Request $request, UserPasswordEncoder $encoder)
    {
        $email = $request->get("email");
        $password = $request->get("password");

        /** @var User $user */
        $user = $this->service->get($email);

        try {
            if (!$user) {
                throw $this->createNotFoundException();
            }

            $isValid = $encoder->isPasswordValid($user, $password);

            if (!$isValid) {
                throw new BadCredentialsException();
            }

            $token = $this->get('lexik_jwt_authentication.encoder')
                ->encode([
                    'email' => $user->getEmail(),
                    'exp' => time() + 3600 // 1 hour expiration
                ]);

            return new JsonResponse(['token' => $token]);
        } catch (\Exception $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                500
            );
        }
    }
}
