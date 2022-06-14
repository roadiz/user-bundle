<?php

declare(strict_types=1);

namespace RZ\Roadiz\UserBundle\Api\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use RZ\Roadiz\UserBundle\Api\Dto\UserOutput;
use RZ\Roadiz\UserBundle\Manager\UserValidationTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserOutputDataTransformer implements DataTransformerInterface
{
    private UserValidationTokenManagerInterface $userValidationTokenManager;

    public function __construct(UserValidationTokenManagerInterface $userValidationTokenManager)
    {
        $this->userValidationTokenManager = $userValidationTokenManager;
    }

    /**
     * @inheritDoc
     */
    public function transform($object, string $to, array $context = []): UserOutput
    {
        if (!$object instanceof UserInterface) {
            throw new \RuntimeException(sprintf('Cannot transform %s to %s', get_class($object), $to));
        }

        $userOutput = new UserOutput();
        $userOutput->identifier = $object->getUserIdentifier();
        $userOutput->roles = $object->getRoles();
        $userOutput->emailValidated = $this->userValidationTokenManager->isUserEmailValidated($object);
        return $userOutput;
    }

    /**
     * @inheritDoc
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $to === UserOutput::class && $data instanceof UserInterface;
    }
}
