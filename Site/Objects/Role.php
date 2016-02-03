<?php
namespace Site\Objects;

use Site\Library\Utilities as Utilities;

final class Role extends Utilities\Enum
{
    const SUPER_ADMIN = 'super_admin';
    const ADMIN = 'admin';
    const MANAGER = 'manager';
    const DESIGNER = 'designer';
    const REVIEWER = 'reviewer';
    const VIEWER = 'viewer';
}