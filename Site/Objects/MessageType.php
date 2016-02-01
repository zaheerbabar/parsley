<?php
namespace Site\Objects;

use Site\Library\Utilities as Utilities;

final class MessageType extends Utilities\Enum
{
    const OTHER = 'other';
    const ERROR = 'error';
    const INFO = 'info';
    const SUCCESS = 'success';
    const WARNING = 'warning';
}