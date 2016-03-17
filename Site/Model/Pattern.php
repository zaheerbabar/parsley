<?php
namespace Site\Model;

use Site\Library\Utilities as Utilities;

class Pattern extends DAL
{
    public function getAll($page = 1, $userId) {
        $records = $this->_pdo->createQueryBuilder()
            ->select('pattern_id', 'pattern_title', 'pattern_description', 'pattern_tags', 'pattern_creation_date', 
                'pattern_status', 'user_id')
            ->from('pattern')
            ->where('user_id = :user_id')
            ->orderBy('pattern_id', 'DESC')
            ->setFirstResult($page)
            ->setMaxResults(PAGE_SIZE)
            ->setParameter('user_id', $userId)
            ->execute()
            ->fetchAll();
            
        $result = [];

        foreach($records as $row) {
            $result[] = (object) [
                'id' => $row['pattern_id'],
                'title' => $row['pattern_title'],
                'description' => $row['pattern_description'],
                'tags' => $row['pattern_tags'],
                'creation_date' => $row['pattern_creation_date'],
                'status' => $row['pattern_status'],
                'user_id' => $row['user_id']
            ];
        }
        
        return $result;
    }
       
    public function totalCount() {
        $count = $this->_pdo->createQueryBuilder()
            ->select('pattern_id')
            ->from('pattern')
            ->execute()
            ->rowCount();
        
        return $count;
    }
    
    public function delete($id) {
        $this->_pdo->createQueryBuilder()
            ->delete('pattern')
            ->where('pattern_id = :pattern_id')
            ->setParameter('pattern_id', (int) $id)
            ->execute();
        
        return true;
    }
    
}