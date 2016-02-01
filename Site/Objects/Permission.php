<?php
namespace Site\Objects;

use Site\Library\Utilities as Utilities;

final class Permission extends Utilities\Enum
{
    const CREATE_USER = 'create_user';
    const CREATE_POST = 'create_post';