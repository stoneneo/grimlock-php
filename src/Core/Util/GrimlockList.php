<?php

namespace Grimlock\Core\Util;

use ArrayObject;
use Grimlock\Core\Exception\GrimlockException;
use JsonSerializable;

/**
 * Class GrimlockList
 * Class that allows manipulating a list of objects
 * @package Grimlock\Util
 * @author Rubén Darío Huamaní Ucharima
 */
class GrimlockList extends ArrayObject implements JsonSerializable
{

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->getArrayCopy();
    }

    /**
     * @param int $index
     * @return mixed
     * @throws GrimlockException
     */
    public function getItem(int $index): mixed
    {
        $size = $this->count();
        if ($index >= 0 && $index < $size)
        {
            return $this->offsetGet($index);
        }
        else
        {
            throw new GrimlockException(GrimlockList::class, "Index Out Of Bounds");
        }
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->count();
    }

}