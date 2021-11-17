<?php echo "<?php\n"; ?>

declare(strict_types=1);

namespace <?php echo $namespace; ?>;

use App\Shared\Domain\Exception\InvalidArgumentException;

final class <?php echo $class_name; ?> implements <?php echo $interface->getShortName(); ?>

{
    /**
     * @throws InvalidArgumentException
     */
    public function __invoke(<?php echo $input_interface->getShortName(); ?> $input, <?php echo $presenter_interface->getShortName(); ?> $presenter): void
    {
        $presenter->present(new <?php echo $output->getShortName(); ?>());
    }
}
