<?php
namespace Site\Model;

use Site\Library\Utilities as Utilities;
use \Doctrine\DBAL as DBAL;
use Site\Library\Debug as Debug;

class Phase extends DAL
{
    public function getTemplatePhases($templateId, $getContentTypes = false) {
        return $this->getPhases(false, $templateId, $getContentTypes);
    }
    
    public function getPhases($isCustom, $parentId, $getContentTypes = false) {
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
        $contentTypes = [];

        foreach($records as $row) {
            if ($getContentTypes) {
                $contentTypes = $this->getPhaseContentTypes($row['phase_id']);
            }
            
            $result[] = (object) [
                'id' => $row['phase_id'],
                'title' => $row['phase_title'],
                'is_custom' => $row['phase_is_custom'],
                'parent_id' => $row['phase_parent_id'],
                'order' => $row['phase_order'],
                'content_types' => $contentTypes
            ];
        }
        
        return $result;
    }
    
    public function getPhaseContentTypes($phaseId) {
        $records = $this->_pdo->createQueryBuilder()
            ->select('phase_content_id', 'phase_id', 'content_type_name', 'content_type_id')
            ->from('phase_content')
            ->where('phase_id = :phase_id')
            ->setParameter('phase_id', (int) $phaseId)
            ->execute()
            ->fetchAll();
            
        $result = [];

        foreach($records as $row) {
            $result[] = (object) [
                'id' => $row['phase_content_id'],
                'phase_id' => $row['phase_id'],
                'name' => $row['content_type_name'],
                'type_id' => $row['content_type_id']
            ];
        }
        
        return $result;
    }

    public function saveTemplatePhases($phases, $templateId) {
        return $this->savePhases($phases, false, $templateId);
    }
    
    public function savePhases($phases, $isCustom, $parentId) {
        $this->_pdo->createQueryBuilder()
            ->delete('phase')
            ->where('phase_parent_id = :parent_id')
            ->setParameter('parent_id', (int) $parentId)
            ->execute();
        
        for ($i = 0; $i < count($phases); $i++) {
            $phase = $phases[$i];
            $phase->order = $i;
            
            // if (empty($phase->id) == false) {
            //     $query = $this->_pdo->createQueryBuilder()
            //         ->update('phase')
            //         ->set('phase_order', $i)
            //         ->where('phase_id = :phase_id')
            //         ->andWhere('phase_is_custom = :is_custom')
            //         ->setParameter('phase_id', (int) $phase->id)
            //         ->setParameter('is_custom', (bool) $isCustom)
            //         ->execute();
            // }
            // else {
            //     $this->create($phase, $isCustom, $parentId);
            // }
            
            $this->create($phase, $isCustom, $parentId);
        }

        return true;
    }

    public function create($phase, $isCustom, $parentId) {
        $values = [
            'phase_title' => ':title',
            'phase_is_custom' => ':is_custom',
            'phase_parent_id ' => ':parent_id',
            'phase_order' => ':order'
            ];

        $this->_pdo->createQueryBuilder()
            ->insert('phase')
            ->values($values)
            ->setParameter('title', $phase->title)
            ->setParameter('is_custom', (bool) $isCustom)
            ->setParameter('parent_id', (int) $parentId)
            ->setParameter('order', (int) $phase->order)
            ->execute();
            
        if (empty($phase->content_types) == false) {
            $this->addPhaseContentTypes($phase->content_types, $this->_pdo->lastInsertId());
        }
        
        return true;
    }
    
    public function addPhaseContentTypes($contentTypes, $phaseId) {
        $values = [
            'phase_id ' => ':phase_id',
            'content_type_name' => ':name',
            'content_type_id' => ':type_id'
            ];
        
        foreach($contentTypes as $contentType) {
            $this->_pdo->createQueryBuilder()
                ->insert('phase_content')
                ->values($values)
                ->setParameter('phase_id', (int) $phaseId)
                ->setParameter('name', $contentType->name)
                ->setParameter('type_id', (int) $contentType->type_id)
                ->execute();
        }

        return true;
    }
    
    public function getContentTypes() {
        $records = $this->_pdo->createQueryBuilder()
            ->select('content_type_id', 'content_type_name', 'content_type_key')
            ->from('content_type')
            ->orderBy('content_type_name', 'ASC')
            ->execute()
            ->fetchAll();
            
        $result = [];

        foreach($records as $row) {
            $result[] = (object) [
                'id' => $row['content_type_id'],
                'name' => $row['content_type_name'],
                'key' => $row['content_type_key']
            ];
        }
        
        return $result;
    }
    
    public function deleteTemplatePhases($templateId) {
        return $this->deletePhases(false, $templateId);
    }
    
    public function deletePhases($isCustom, $parentId) {
        $this->_pdo->createQueryBuilder()
            ->delete('phase')
            ->where('phase_is_custom = :is_custom')
            ->andWhere('phase_parent_id = :parent_id')
            ->setParameter('is_custom', (bool) $isCustom)
            ->setParameter('parent_id', (int) $parentId)
            ->execute();
        
        return true;
    }
}