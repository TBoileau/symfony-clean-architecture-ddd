<?php echo "<?php\n"; ?>

declare(strict_types=1);

namespace <?php echo $namespace; ?>;

interface <?php echo $class_name; ?>

{
    public function present(<?php echo $output->getShortName(); ?> $output): void;
}
