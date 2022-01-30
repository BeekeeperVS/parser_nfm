<?php


namespace app\service\enum;


interface BaseEnumInterface
{
    public  function getList(): array;

    public  function getValue($itemId);

    public  function isEmpty($itemId): bool;
}