<?php echo "<?php\n"; ?>

declare(strict_types=1);

namespace <?php echo $namespace; ?>;

use <?php echo $interface->getFullName(); ?>;

final class <?php echo $class_name; ?> implements <?php echo $interface->getShortName(); ?>

{
}
