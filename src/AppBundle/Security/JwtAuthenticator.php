<?php

namespace AppBundle\Security;

use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Services\UserService;
use AppBundle\Entity\User;

class JwtAuthenticator extends AbstractGuardAuthenticator
{
    /** @var EntityManager */
    private $em;

    /** @var JWTEncoderInterface */
    private $jwtEncoder;

    /**
     * The password encoder
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /** @var UserService  */
    private $userService;

    /**
     * @param EntityManager $em
     * @param JWTEncoderInterface $jwtEncoder
     * @param UserPasswordEncoderInterface $encoder
     * @param UserService $userService
     */
    public function __construct(
        EntityManager $em,
        JWTEncoderInterface $jwtEncoder,
        UserPasswordEncoderInterface $encoder,
        UserService $userService
    ) {
        $this->encoder = $encoder;
        $this->em = $em;
        $this->jwtEncoder = $jwtEncoder;
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $authException
     *
     * @return JsonResponse|Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse(['message' => 'Authentication required!'], 401);
    }

    /**
     * @param Request $request
     *
     * @return array|bool|false|string|void
     */
    public function getCredentials(Request $request)
    {
        if (!$request->headers->has('Authorization')) {
            return;
        }

        $extractor = new AuthorizationHeaderTokenExtractor(
            'Bearer',
            'Authorization'
        );

        $token = $extractor->extract($request);

        if (!$token) {
            return;
        }

        return $token;
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return User
     */
    public function getUser($credentials, UserProviderInterface $userProvider) : User
    {
        $data = $this->jwtEncoder->decode($credentials);

        if ($data == false) {
            throw new CustomUserMessageAuthenticationException('Invalid Token');
        }

        $email = $data['email'];
        $user = $this->em->getRepository('AppBundle:User')
            ->findOneBy(['email' => $email]);

        if (!$user) {
            throw new AuthenticationCredentialsNotFoundException();
        }

        return $user;
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return JsonResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(['message' => $exception->getMessage()], 401);
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     *
     * @return null|Response|void
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return;
    }

    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
