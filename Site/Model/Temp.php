<?php
namespace Site\Model;

// use \Doctrine\DBAL as DBAL;

class Temp extends DAL
{
    public function getPatterns() {
        
        $records = $this->_pdo->createQueryBuilder()
            ->select('*')
            ->from('pattern')
            ->execute()
            ->fetchAll();
            
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
}