<?php

namespace Whodunit\Framework\Enums\Concerns;

trait EnumTrait {

    /**
     * @return string[]
     */
    public static function values() : array {
        return array_column( self::cases(), 'value' );
    }

    public static function names() : array {
        return array_column( self::cases(), 'name' );
    }

    public function equals( self $enum ) : bool {
        return $this === $enum;
    }
}
