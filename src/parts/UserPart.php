<?php


namespace Src\parts;


class UserPart
{
    public string $status;
    public int    $active;
    public bool   $blocked;
    public int    $created_at;
    public int    $id;
    public string $name;

    /**
     * @var PermissionsPart[]
     */
    public array $permissions;


}