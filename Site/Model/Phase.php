<?php
namespace Site\Model;

use Site\Library\Utilities as Utilities;
use \Doctrine\DBAL as DBAL;
use Site\Library\Debug as Debug;

class Phase extends DAL
{
    public function getTemplatePhases($id) {
        return $this->getPhases(false, $id);
    }
    
    public function getPhases($isCustom, $parentId) {
        $records = $this->_pdo->createQueryBuilder()
            ->select('phase_id', 'phase_title', 'phase_is_custom', 'phase_parent_id', 'phase_order')
            ->from('phase')
            ->where('phase_is_custom = :is_custom')
            ->andWhere('phase_parent_id = :parent_id')
            ->setParameter('is_custom', (bool) $isCustom)
            ->setParameter('parent_id', (int) $parentId)
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

    public function addTemplatePhases($phases, $templateId) {
        return $this->addPhases($phases, false, $templateId);
    }
    
    public function addPhases($phases = [], $isCustom, $parentId) {
        for ($i = 0; $i < count($phases); $i++) {
            $this->_pdo->createQueryBuilder()
                ->update('phase')
                ->set('phase_order', $i)
                ->where('phase_id = :phase_id')
                ->andWhere('phase_is_custom = :is_custom')
                ->andWhere('phase_parent_id = :parent_id')
                ->setParameter('phase_id', (int) $phases[$i])
                ->setParameter('is_custom', (bool) $isCustom)
                ->setParameter('parent_id', (int) $parentId)
                ->execute();
        }

        return true;
    }
    
    public function getContentTypes() {
        $records = $this->_pdo->createQueryBuilder()
            ->select('content_type_id', 'content_type_title', 'content_type_key')
            ->from('content_type')
            ->orderBy('content_type_title', 'ASC')
            ->execute()
            ->fetchAll();
            
        $result = [];

        foreach($records as $row) {
            $result[] = (object) [
                'id' => $row['content_type_id'],
                'title' => $row['content_type_title'],
                'key' => $row['content_type_key']
            ];
        }
        
        return $result;
    }
}