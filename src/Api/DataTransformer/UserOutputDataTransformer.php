<?php

declare(strict_types=1);

namespace RZ\Roadiz\UserBundle\Api\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use RZ\Roadiz\UserBundle\Api\Dto\UserOutput;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserOutputDataTransformer implements DataTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof UserInterface) {
            throw new \RuntimeException(sprintf('Cannot transform %s to %s', get_class($object), $to));
        }
        $userOutput = new UserOutput();
        $userOutput->identifier = $object->getUserIdentifier();
        $userOutput->roles = $object->getRoles();
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
