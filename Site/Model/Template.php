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
        $result = $this->_pdo->createQueryBuilder()
            ->select('template_id', 'template_title', 'template_is_default', 'template_creation_date')
            ->from('template')
            ->where('template_id = :id')
            ->setParameter('id', (int) $id)
            ->execute()
            ->fetch();

        if ($result) {
            $result = (object) [
                'id' => $result['template_id'],
                'title' => $result['template_title'],
                'is_default' => $result['template_is_default'],
                'creation_date' => $result['template_creation_date']
            ];
        }
        
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
    
    public function create($template) {
        $values = [
            'template_title' => ':title',
            'template_is_default' => ':is_default',
            'template_creation_date' => ':creation_date'
            ];

        $this->_pdo->createQueryBuilder()
            ->insert('template')
            ->values($values)
            ->setParameter('title', $template->title)
            ->setParameter('is_default', (bool) $template->is_default)
            ->setParameter('creation_date', Utilities\DateTime::dbDateFormat())
            ->execute();
        
        return true;
    }
    
    public function update($template) {
        $this->_pdo->createQueryBuilder()
            ->update('template')
            ->set('template_title', ':title')
            ->set('template_is_default', ':is_default')
            ->where('template_id = :id')
            ->setParameter('title', $template->title)
            ->setParameter('is_default', $template->is_default)
            ->setParameter('id', (int) $template->id)
            ->execute();

        return true;
    }
    
    public function delete($id) {
        $this->_pdo->createQueryBuilder()
            ->delete('template')
            ->where('template_id = :template_id')
            ->setParameter('template_id', (int) $id)
            ->execute();
        
        return true;
    }
    
}