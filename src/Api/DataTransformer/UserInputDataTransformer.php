<?php

declare(strict_types=1);

namespace RZ\Roadiz\UserBundle\Api\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use RZ\Roadiz\CoreBundle\Bag\Roles;
use RZ\Roadiz\CoreBundle\Entity\User;
use RZ\Roadiz\UserBundle\Api\Dto\UserInput;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserInputDataTransformer implements DataTransformerInterface
{
    private Roles $rolesBag;

    /**
     * @param Roles $rolesBag
     */
    public function __construct(Roles $rolesBag)
    {
        $this->rolesBag = $rolesBag;
    }

    public function transform($object, string $to, array $context = []): User
    {
        if (!$object instanceof UserInput) {
            throw new \RuntimeException(sprintf('Cannot transform %s to %s', get_class($object), $to));
        }

        $user = new User();
        $user->setEmail($object->email);
        $user->setUsername($object->email);
        $user->setFirstName($object->firstName);
        $user->setLastName($object->lastName);
        $user->setPlainPassword($object->clearPassword);
        $user->addRoleEntity($this->rolesBag->get('ROLE_PUBLIC_USER'));
        $user->sendCreationConfirmationEmail(true);

        return $user;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof UserInterface) {
            return false;
        }

        return User::class === $to && UserInput::class === ($context['input']['class'] ?? null);
    }
}
