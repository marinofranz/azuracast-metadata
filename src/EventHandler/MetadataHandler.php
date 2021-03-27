<?php

declare(strict_types=1);

namespace Plugin\MetadataPlugin\EventHandler;

use App\Event;
use NowPlaying\Result\Result;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExampleNowPlayingEventHandler implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Event\Radio\GenerateRawNowPlaying::class => [
                ['setMetadata', -20]
            ],
        ];
    }

    public function setMetadata(Event\Radio\GenerateRawNowPlaying $event)
    {
        $np_raw = $event->getResult()->toArray();

        $np_raw['now_playing']['artist'] = str_replace(array(' X ', '/', ';'), ', ', $np_raw['now_playing']['artist']);
        $np_raw['now_playing']['title'] = str.replace(array('/', ';'), ', ', $np_raw['now_playing']['title']);

        $pos = strrpos($np_raw['now_playing']['artist'], ', ');
        if($pos !== false)
        {
           $np_raw['now_playing']['artist'] = substr_replace($np_raw['now_playing']['artist'], ' & ', $pos, strlen(', '));
        }

        $event->setResult(Result::fromArray($np_raw));
    }
}
