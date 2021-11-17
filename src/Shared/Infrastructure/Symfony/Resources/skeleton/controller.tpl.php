<?php echo "<?php\n"; ?>

declare(strict_types=1);

namespace <?php echo $namespace; ?>;

use <?php echo $responder_interface->getFullName(); ?>;
use <?php echo $presenter_interface->getFullName(); ?>;
use <?php echo $use_case_interface->getFullName(); ?>;
use <?php echo $input->getFullName(); ?>;
<?php if ($has_form) {?>
use <?php echo $form->getFullName(); ?>;
<?php }?>
use <?php echo $view_model->getFullName(); ?>;
<?php if ($has_form) {?>
use App\Shared\Domain\Exception\InvalidArgumentException;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
<?php }?>
use Symfony\Component\HttpFoundation\Response;

final class <?php echo $class_name; ?>

{
    public function __invoke(
<?php if ($has_form) {?>
        Request $request,
        FormFactoryInterface $formFactory,
<?php }?>
        <?php echo $responder_interface->getShortName(); ?> $responder,
        <?php echo $presenter_interface->getShortName(); ?> $presenter,
        <?php echo $use_case_interface->getShortName(); ?> $useCase,
    ): Response {
        $input = new <?php echo $input->getShortName(); ?>();
<?php if ($has_form) {?>
        $form = $formFactory->create(<?php echo $form->getShortName(); ?>::class, $input)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $useCase($input, $presenter);

                return $responder->redirect();
            } catch (InvalidArgumentException $exception) {
                $form->addError(new FormError($exception->getMessage()));
            }
        }

        return $responder->send(new <?php echo $view_model->getShortName(); ?>($form));
<?php } else { ?>
        $useCase($input, $presenter);
        return $responder->send(new <?php echo $view_model->getShortName(); ?>());
<?php }?>
    }
}
