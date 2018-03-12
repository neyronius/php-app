
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
	    $builder->useAnnotations(true);
        $container = $builder->build();
    }

    return $container;
}

return DI();

