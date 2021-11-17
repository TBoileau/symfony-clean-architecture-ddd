<?php echo "<?php\n"; ?>

declare(strict_types=1);

namespace <?php echo $namespace; ?>;

use <?php echo $view_model->getFullName(); ?>;
use App\Shared\UserInterface\Responder\TwigResponder;
<?php if ($has_form) {?>
use Symfony\Component\HttpFoundation\RedirectResponse;
<?php }?>
use Symfony\Component\HttpFoundation\Response;
<?php if ($has_form) {?>
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
<?php }?>

final class <?php echo $class_name; ?> implements <?php echo $interface->getShortName(); ?>

{
    public function __construct(private TwigResponder $decorated<?php if ($has_form) {?>, private UrlGeneratorInterface $urlGenerator<?php }?>)
    {
    }

    public function send(<?php echo $view_model->getShortName(); ?> $viewModel): Response
    {
        return $this->decorated->send('<?php echo $template; ?>', $viewModel);
    }
<?php if ($has_form) {?>

    public function redirect(): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate(''));
    }
<?php }?>
}
