<?php

namespace AppBundle\Entity;

/**
 * Class SongFieldTypes.
 */
final class SongFieldTypes
{
    const INTRO = 'Intro';
    const VERSE = 'Verse';
    const PRECHORUS = 'PreChorus';
    const CHORUS = 'Chorus';
    const BRIDGE = 'Bridge';
    const OUTRO = 'Outro';
    const CUSTOM = 'Custom';
    const FREE_STYLE = 'Freestyle';

    const TYPES = [
        self::INTRO,
        self::VERSE,
        self::PRECHORUS,
        self::CHORUS,
        self::BRIDGE,
        self::OUTRO,
        self::CUSTOM,
        self::FREE_STYLE,
    ];
}
