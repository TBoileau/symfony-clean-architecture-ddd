<?php echo "<?php\n"; ?>

declare(strict_types=1);

namespace App\Security\UserInterface\Form;

use <?php echo $input->getFullName(); ?>;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class <?php echo $class_name; ?> extends AbstractType
{
    /**
     * @param array<string, int|bool|string|null> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', <?php echo $input->getShortName(); ?>::class);
    }
}
