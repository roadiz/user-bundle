<?php

declare(strict_types=1);

namespace RZ\Roadiz\UserBundle\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use RZ\Roadiz\CoreBundle\Entity\User;
use RZ\Roadiz\UserBundle\Event\UserSignedUp;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class SignupController
{
    private Security $security;
    private ValidatorInterface $validator;
    private EventDispatcherInterface $eventDispatcher;
    private RateLimiterFactory $userSignupLimiter;

    public function __construct(
        ValidatorInterface $validator,
        Security $security,
        EventDispatcherInterface $eventDispatcher,
        RateLimiterFactory $userSignupLimiter
    ) {
        $this->validator = $validator;
        $this->security = $security;
        $this->eventDispatcher = $eventDispatcher;
        $this->userSignupLimiter = $userSignupLimiter;
    }

    public function __invoke(Request $request, User $data): User
    {
        if ($this->security->isGranted('ROLE_USER')) {
            throw new AccessDeniedHttpException('Cannot sign-up: you\'re already authenticated.');
        }
        $limiter = $this->userSignupLimiter->create($request->getClientIp());
        $limit = $limiter->consume();
        if (false === $limit->isAccepted()) {
            throw new TooManyRequestsHttpException($limit->getRetryAfter()->getTimestamp());
        }
        $this->validator->validate($data);
        $this->eventDispatcher->dispatch(new UserSignedUp($data));

        return $data;
    }
}
