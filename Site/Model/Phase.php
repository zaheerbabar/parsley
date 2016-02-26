<?php
namespace Site\Model;

use Site\Library\Utilities as Utilities;
use \Doctrine\DBAL as DBAL;
use Site\Library\Debug as Debug;

class Phase extends DAL
{
    public function getTemplatePhases($id) {
        return $this->getAllPhases(false, $id);
    }
    
    public function getAllPhases($isCustom, $parentId) {
        $records = $this->_pdo->createQueryBuilder()
            ->select('phase_id', 'phase_title', 'phase_is_custom', 'phase_parent_id', 'phase_order')
            ->from('phase')
            ->where('phase_is_custom = :is_custom')
            ->andWhere('phase_parent_id = :id')
            ->setParameter('id', (int) $parentId)
            ->setParameter('is_custom', (bool) $isCustom)
            ->orderBy('phase_order', 'ASC')
            ->execute()
            ->fetchAll();
            
        $result = [];

        foreach($records as $row) {
            $result[] = (object) [
                'id' => $row['phase_id'],
                'title' => $row['phase_title'],
                'is_custom' => $row['phase_is_custom'],
                'parent_id' => $row['phase_parent_id'],
                'order' => $row['phase_order']
            ];
        }
        
        return $result;
    }
}