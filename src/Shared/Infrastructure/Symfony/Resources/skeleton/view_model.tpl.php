<?php echo "<?php\n"; ?>

declare(strict_types=1);

namespace <?php echo $namespace; ?>;

use App\Shared\UserInterface\ViewModel\ViewModelInterface;
<?php if ($has_form) {?>
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
<?php }?>

final class <?php echo $class_name; ?> implements ViewModelInterface
{
<?php if ($has_form) {?>
    public FormView $form;

<?php }?>
    public function __construct(<?php if ($has_form) {?>FormInterface $form<?php }?>)
    {
<?php if ($has_form) {?>
        $this->form = $form->createView();
<?php }?>
    }
}
