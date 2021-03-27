<?php

declare(strict_types=1);

use App\Event;

return function (\App\EventDispatcher $dispatcher)
{
    $dispatcher->addSubscriber(new \Plugin\MetadataPlugin\EventHandler\MetadataHandler); 
};
