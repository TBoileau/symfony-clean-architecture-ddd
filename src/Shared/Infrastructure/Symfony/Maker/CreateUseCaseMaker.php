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

namespace App\Shared\Infrastructure\Symfony\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\HttpKernel\KernelInterface;
use function Symfony\Component\String\u;

final class CreateUseCaseMaker extends AbstractMaker
{
    private string $projectDir;

    public function __construct(KernelInterface $kernel)
    {
        $this->projectDir = $kernel->getProjectDir();
    }

    public static function getCommandName(): string
    {
        return 'make:use-case';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command
            ->addArgument('domain', InputArgument::REQUIRED)
            ->addArgument('name', InputArgument::REQUIRED)
            ->addOption('form', 'f', InputOption::VALUE_NONE);
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        /** @var string $domain */
        $domain = $input->getArgument('domain');

        /** @var string $name */
        $name = $input->getArgument('name');

        /** @var bool $hasForm */
        $hasForm = $input->getOption('form');

        $template = $this->createView($generator, $hasForm, $domain, $name);

        $viewModel = $this->createViewModel($generator, $hasForm, $domain, $name);

        $output = $this->createOutput($generator, $domain, $name);

        $inputInterface = $this->createInputInterface($generator, $domain, $name);
        $input = $this->createInput($generator, $inputInterface, $domain, $name);

        $presenterInterface = $this->createPresenterInterface($generator, $output, $domain, $name);
        $this->createPresenter($generator, $output, $presenterInterface, $domain, $name);

        $responderInterface = $this->createResponderInterface($generator, $hasForm, $viewModel, $domain, $name);
        $this->createResponder($generator, $hasForm, $viewModel, $responderInterface, $template, $domain, $name);

        $useCaseInterface = $this->createUseCaseInterface(
            $generator,
            $presenterInterface,
            $inputInterface,
            $domain,
            $name
        );
        $this->createUseCase(
            $generator,
            $presenterInterface,
            $inputInterface,
            $output,
            $useCaseInterface,
            $domain,
            $name
        );

        $form = null;

        if ($hasForm) {
            $form = $this->createForm($generator, $input, $domain, $name);
        }

        $this->createController(
            $generator,
            $hasForm,
            $presenterInterface,
            $responderInterface,
            $useCaseInterface,
            $input,
            $form,
            $viewModel,
            $domain,
            $name
        );
    }

    private function createController(
        Generator $generator,
        bool $hasForm,
        ClassNameDetails $presenterInterface,
        ClassNameDetails $responderInterface,
        ClassNameDetails $useCaseInterface,
        ClassNameDetails $input,
        ?ClassNameDetails $form,
        ClassNameDetails $viewModel,
        string $domain,
        string $name
    ): void {
        $classNameDetail = $generator->createClassNameDetails(
            $name,
            sprintf('%s\\UserInterface\\Controller\\', $domain),
            'Controller'
        );

        $templatePath = sprintf(
            '%s/src/Shared/Infrastructure/Symfony/Resources/skeleton/controller.tpl.php',
            $this->projectDir
        );

        $generator->generateClass(
            $classNameDetail->getFullName(),
            $templatePath,
            [
                'responder_interface' => $responderInterface,
                'presenter_interface' => $presenterInterface,
                'use_case_interface' => $useCaseInterface,
                'input' => $input,
                'form' => $form,
                'has_form' => $hasForm,
                'view_model' => $viewModel,
            ]
        );

        $generator->writeChanges();
    }

    private function createForm(
        Generator $generator,
        ClassNameDetails $input,
        string $domain,
        string $name
    ): ClassNameDetails {
        $classNameDetail = $generator->createClassNameDetails(
            $name,
            sprintf('%s\\UserInterface\\Form\\', $domain),
            'Type'
        );

        $templatePath = sprintf(
            '%s/src/Shared/Infrastructure/Symfony/Resources/skeleton/form.tpl.php',
            $this->projectDir
        );

        $generator->generateClass($classNameDetail->getFullName(), $templatePath, ['input' => $input]);

        $generator->writeChanges();

        return $classNameDetail;
    }

    private function createUseCaseInterface(
        Generator $generator,
        ClassNameDetails $presenterInterface,
        ClassNameDetails $inputInterface,
        string $domain,
        string $name
    ): ClassNameDetails {
        $classNameDetail = $generator->createClassNameDetails(
            $name,
            sprintf('%s\\Domain\\UseCase\\%s\\', $domain, $name),
            'Interface'
        );

        $templatePath = sprintf(
            '%s/src/Shared/Infrastructure/Symfony/Resources/skeleton/use_case_interface.tpl.php',
            $this->projectDir
        );

        $generator->generateClass(
            $classNameDetail->getFullName(),
            $templatePath,
            [
                'presenter_interface' => $presenterInterface,
                'input_interface' => $inputInterface,
            ]
        );

        $generator->writeChanges();

        return $classNameDetail;
    }

    private function createUseCase(
        Generator $generator,
        ClassNameDetails $presenterInterface,
        ClassNameDetails $inputInterface,
        ClassNameDetails $output,
        ClassNameDetails $interface,
        string $domain,
        string $name
    ): void {
        $classNameDetail = $generator->createClassNameDetails(
            $name,
            sprintf('%s\\Domain\\UseCase\\%s\\', $domain, $name)
        );

        $templatePath = sprintf(
            '%s/src/Shared/Infrastructure/Symfony/Resources/skeleton/use_case.tpl.php',
            $this->projectDir
        );

        $generator->generateClass(
            $classNameDetail->getFullName(),
            $templatePath,
            [
                'interface' => $interface,
                'output' => $output,
                'presenter_interface' => $presenterInterface,
                'input_interface' => $inputInterface,
            ]
        );

        $generator->writeChanges();
    }

    private function createResponderInterface(
        Generator $generator,
        bool $hasForm,
        ClassNameDetails $viewModel,
        string $domain,
        string $name
    ): ClassNameDetails {
        $classNameDetail = $generator->createClassNameDetails(
            $name,
            sprintf('%s\\UserInterface\\Responder\\%s\\', $domain, $name),
            'ResponderInterface'
        );

        $templatePath = sprintf(
            '%s/src/Shared/Infrastructure/Symfony/Resources/skeleton/responder_interface.tpl.php',
            $this->projectDir
        );

        $generator->generateClass(
            $classNameDetail->getFullName(),
            $templatePath,
            [
                'view_model' => $viewModel,
                'has_form' => $hasForm,
            ]
        );

        $generator->writeChanges();

        return $classNameDetail;
    }

    private function createResponder(
        Generator $generator,
        bool $hasForm,
        ClassNameDetails $viewModel,
        ClassNameDetails $interface,
        string $template,
        string $domain,
        string $name
    ): void {
        $classNameDetail = $generator->createClassNameDetails(
            $name,
            sprintf('%s\\UserInterface\\Responder\\%s', $domain, $name),
            'Responder'
        );

        $templatePath = sprintf(
            '%s/src/Shared/Infrastructure/Symfony/Resources/skeleton/responder.tpl.php',
            $this->projectDir
        );

        $generator->generateClass(
            $classNameDetail->getFullName(),
            $templatePath,
            [
                'interface' => $interface,
                'view_model' => $viewModel,
                'template' => $template,
                'has_form' => $hasForm,
            ]
        );

        $generator->writeChanges();
    }

    private function createPresenterInterface(
        Generator $generator,
        ClassNameDetails $output,
        string $domain,
        string $name
    ): ClassNameDetails {
        $classNameDetail = $generator->createClassNameDetails(
            $name,
            sprintf('%s\\Domain\\UseCase\\%s\\', $domain, $name),
            'PresenterInterface'
        );

        $templatePath = sprintf(
            '%s/src/Shared/Infrastructure/Symfony/Resources/skeleton/presenter_interface.tpl.php',
            $this->projectDir
        );

        $generator->generateClass($classNameDetail->getFullName(), $templatePath, ['output' => $output]);

        $generator->writeChanges();

        return $classNameDetail;
    }

    private function createPresenter(
        Generator $generator,
        ClassNameDetails $output,
        ClassNameDetails $interface,
        string $domain,
        string $name
    ): void {
        $classNameDetail = $generator->createClassNameDetails(
            $name,
            sprintf('%s\\UserInterface\\Presenter\\', $domain),
            'Presenter'
        );

        $templatePath = sprintf(
            '%s/src/Shared/Infrastructure/Symfony/Resources/skeleton/presenter.tpl.php',
            $this->projectDir
        );

        $generator->generateClass(
            $classNameDetail->getFullName(),
            $templatePath,
            [
                'interface' => $interface,
                'output' => $output,
            ]
        );

        $generator->writeChanges();
    }

    private function createInputInterface(Generator $generator, string $domain, string $name): ClassNameDetails
    {
        $classNameDetail = $generator->createClassNameDetails(
            $name,
            sprintf('%s\\Domain\\UseCase\\%s\\', $domain, $name),
            'InputInterface'
        );

        $templatePath = sprintf(
            '%s/src/Shared/Infrastructure/Symfony/Resources/skeleton/input_interface.tpl.php',
            $this->projectDir
        );

        $generator->generateClass($classNameDetail->getFullName(), $templatePath);

        $generator->writeChanges();

        return $classNameDetail;
    }

    private function createInput(
        Generator $generator,
        ClassNameDetails $interface,
        string $domain,
        string $name
    ): ClassNameDetails {
        $classNameDetail = $generator->createClassNameDetails(
            $name,
            sprintf('%s\\UserInterface\\Input\\', $domain),
            'Input'
        );

        $templatePath = sprintf(
            '%s/src/Shared/Infrastructure/Symfony/Resources/skeleton/input.tpl.php',
            $this->projectDir
        );

        $generator->generateClass($classNameDetail->getFullName(), $templatePath, ['interface' => $interface]);

        $generator->writeChanges();

        return $classNameDetail;
    }

    private function createOutput(Generator $generator, string $domain, string $name): ClassNameDetails
    {
        $classNameDetail = $generator->createClassNameDetails(
            $name,
            sprintf('%s\\Domain\\UseCase\\%s\\', $domain, $name),
            'Output'
        );

        $templatePath = sprintf(
            '%s/src/Shared/Infrastructure/Symfony/Resources/skeleton/output.tpl.php',
            $this->projectDir
        );

        $generator->generateClass($classNameDetail->getFullName(), $templatePath);

        $generator->writeChanges();

        return $classNameDetail;
    }

    private function createViewModel(
        Generator $generator,
        bool $hasForm,
        string $domain,
        string $name
    ): ClassNameDetails {
        $classNameDetail = $generator->createClassNameDetails(
            $name,
            sprintf('%s\\UserInterface\\ViewModel\\', $domain),
            'ViewModel'
        );

        $templatePath = sprintf(
            '%s/src/Shared/Infrastructure/Symfony/Resources/skeleton/view_model.tpl.php',
            $this->projectDir
        );

        $generator->generateClass($classNameDetail->getFullName(), $templatePath, ['has_form' => $hasForm]);

        $generator->writeChanges();

        return $classNameDetail;
    }

    private function createView(Generator $generator, bool $hasForm, string $domain, string $name): string
    {
        $filename = sprintf('%s.html.twig', u($name)->snake()->toString());

        $targetPath = sprintf(
            '../../../../../%s/Infrastructure/Symfony/Resources/templates/%s',
            $domain,
            $filename
        );

        $templatePath = sprintf(
            '%s/src/Shared/Infrastructure/Symfony/Resources/skeleton/template.tpl.php',
            $this->projectDir
        );

        $generator->generateTemplate($targetPath, $templatePath, ['has_form' => $hasForm]);

        $generator->writeChanges();

        return sprintf('@%s/%s', u($domain)->snake()->toString(), $filename);
    }
}
