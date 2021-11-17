<?php echo "<?php\n"; ?>

declare(strict_types=1);

namespace <?php echo $namespace; ?>;

use <?php echo $view_model->getFullName(); ?>;
<?php if ($has_form) {?>
    use Symfony\Component\HttpFoundation\RedirectResponse;
<?php }?>
use Symfony\Component\HttpFoundation\Response;

interface <?php echo $class_name; ?>

{
    public function send(<?php echo $view_model->getShortName(); ?> $viewModel): Response;
<?php if ($has_form) {?>

    public function redirect(): RedirectResponse;
<?php }?>
}
