<?php

declare(strict_types=1);

namespace App\Security\Domain\Tests\Fixtures\UserInterface\Presenter;

use App\Security\Domain\UseCase\RequestForgottenPassword\RequestForgottenPasswordOutput;
use App\Security\Domain\UseCase\RequestForgottenPassword\RequestForgottenPasswordPresenterInterface;

final class RequestForgottenPasswordPresenter implements RequestForgottenPasswordPresenterInterface
{
    public RequestForgottenPasswordOutput $output;

    public function present(RequestForgottenPasswordOutput $output): void
    {
        $this->output = $output;
    }
}
