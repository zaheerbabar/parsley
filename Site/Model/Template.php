<?php
namespace Site\Model;

use Site\Library\Utilities as Utilities;

class Template extends DAL
{
    public function getAll($page = 1) {
        $records = $this->_pdo->createQueryBuilder()
            ->select('template_id', 'template_title', 'template_is_default', 'template_creation_date')
            ->from('template')
            ->orderBy('template_id', 'DESC')
            ->setFirstResult($page)
            ->setMaxResults(PAGE_SIZE)
            ->execute()
            ->fetchAll();
            
        $result = [];

        foreach($records as $row) {
            $result[] = (object) [
                'id' => $row['template_id'],
                'title' => $row['template_title'],
                'is_default' => $row['template_is_default'],
                'creation_date' => $row['template_creation_date']
            ];
        }
        
        return $result;
    }
    
    public function getByID($id) {
        $record = $this->_pdo->createQueryBuilder()
            ->select('template_id', 'template_title', 'template_is_default', 'template_creation_date')
            ->from('template')
            ->where('template_id = :id')
            ->setParameter('id', (int) $id)
            ->execute()
            ->fetch();

            $result = (object) [
                'id' => $record['template_id'],
                'title' => $record['template_title'],
                'is_default' => $record['template_is_default'],
                'creation_date' => $record['template_creation_date']
            ];
        
        return $result;
    }
    
    public function totalCount() {
        $count = $this->_pdo->createQueryBuilder()
            ->select('template_id')
            ->from('template')
            ->execute()
            ->rowCount();
        
        return $count;
    }
    
    public function delete($templateId) {
        $this->_pdo->createQueryBuilder()
            ->delete('template')
            ->where('template_id = :template_id')
            ->setParameter('template_id', (int) $templateId)
            ->execute();
        
        return true;
    }
    
}