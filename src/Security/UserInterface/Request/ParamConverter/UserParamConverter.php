<?php

/**
 * Copyright (C) Thomas Boileau - All Rights Reserved.
 *
 * This source code is protected under international copyright law.
 * All rights reserved and protected by the copyright holders.
 * This file is confidential and only available to authorized individuals with the
 * permission of the copyright holders. If you encounter this file and do not have
 * permission, please contact the copyright holders and delete this file.
 */

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
            /** @var string $token */
            $token = $request->attributes->get('token');

            $token = UuidToken::createFromString($token);

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
