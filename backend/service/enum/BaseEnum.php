<?php

namespace app\service\enum;

abstract class BaseEnum implements BaseEnumInterface
{
    /** @var BaseEnumInterface[] */
    public static $instances = [];

    /**
     * @return BaseEnumInterface
     */
    public static function getInstance(): BaseEnumInterface
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     * Return Value by Enum Key
     * @param $itemId
     * @return mixed
     * @throws EnumException
     */
    public function getValue($itemId)
    {
        $list = $this->getList();
        if (!empty($list[$itemId])) {
            return $list[$itemId];
        }

        throw new EnumException(sprintf('Not found EnumElement Id: %s in %s',
            $itemId,
            get_class($this)
        ));
    }

    /**
     * @param $itemId
     * @return bool
     */
    public function isEmpty($itemId): bool
    {
        $list = $this->getList();
        return !empty($list[$itemId]);
    }
}