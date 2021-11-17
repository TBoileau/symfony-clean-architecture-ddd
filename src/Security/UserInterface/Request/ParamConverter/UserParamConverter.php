<?php

declare(strict_types=1);

namespace App\Security\UserInterface\Request\ParamConverter;

use App\Security\Domain\Contract\Gateway\UserGateway;
use App\Security\Domain\Entity\User;
use App\Shared\Domain\ValueObject\Token\UuidToken;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

final class UserParamConverter implements ParamConverterInterface
{
    /**
     * @param UserGateway<User> $userGateway
     */
    public function __construct(private UserGateway $userGateway)
    {
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        if ($request->attributes->has('token')) {
            $token = UuidToken::createFromString($request->attributes->getAlpha('token'));

            $user = $this->userGateway->getUserByForgottenPasswordToken($token);

            if (null === $user) {
                return false;
            }

            $request->attributes->set($configuration->getName(), $user);
        }

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return User::class === $configuration->getClass();
    }
}
