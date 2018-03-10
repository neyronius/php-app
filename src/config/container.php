
<?php

/**
 * Get DI container
 *
 * @return \DI\Container
 * @throws Exception
 */
function DI()
{
    static $container = null;

    if($container === null){
        $builder = new DI\ContainerBuilder();
        $builder->addDefinitions(__DIR__ . '/di.php');
        $container = $builder->build();
    }

    return $container;
}

return DI();

