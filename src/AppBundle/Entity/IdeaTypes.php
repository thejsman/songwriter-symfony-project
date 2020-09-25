<?php

namespace AppBundle\Entity;

/**
 * Class IdeaTypes.
 */
final class IdeaTypes
{
    const RHYME = 'rhyme';
    const WORD = 'word';
    const PHRASE = 'phrase';

    const TYPES = [self::PHRASE, self::WORD, self::RHYME];

    /**
     * @return string
     */
    public static function getTypesAsString(): string
    {
        return \join(', ', self::TYPES);
    }
}
