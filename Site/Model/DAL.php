<?php
namespace Site\Model;

use Site\Components as Components;

class DAL
{
    protected $_pdo = null;

    public function __construct() {
        $this->_pdo = Components\Database::loadConnection();
    }

    protected function _dataObjectIterator($funcMapper, array $data) {
        if (empty($funcMapper)) throw new InvalidArgumentException('Mapper function [$funcMapper] is not set.');

        if (is_array($data)) {
            $objects = [];

            foreach ($data as $row) {
                $objects[] = $funcMapper($row);
            }

            return $objects;
        }

        return $funcMapper($data);
    }
}