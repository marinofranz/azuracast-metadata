<?php

declare(strict_types=1);

namespace Plugin\MetadataPlugin\EventHandler;

use App\Event;
use NowPlaying\Result\Result;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MetadataHandler implements EventSubscriberInterface
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

        $np_raw['currentSong']['artist'] = str_replace(array(' X ', '/', ';'), ', ', $np_raw['currentSong']['artist']);
        $np_raw['currentSong']['title'] = str_replace(array('/', ';'), ', ', $np_raw['currentSong']['title']);

        $pos = strrpos($np_raw['currentSong']['artist'], ', ');
        if($pos !== false)
        {
           $np_raw['currentSong']['artist'] = substr_replace($np_raw['currentSong']['artist'], ' & ', $pos, strlen(', '));
        }

        $event->setResult(Result::fromArray($np_raw));
    }
}
