<?php
namespace Site\Model;

use Site\Library\Utilities as Utilities;
use \Doctrine\DBAL as DBAL;
use Site\Library\Debug as Debug;

class Project extends DAL
{
    public function getAll($page = 1) {
        $records = $this->_pdo->createQueryBuilder()
            ->select('project_id', 'project_title', 'project_description', 'project_creation_date')
            ->from('project')
            ->orderBy('project_id', 'DESC')
            ->setFirstResult($page)
            ->setMaxResults(PAGE_SIZE)
            ->execute()
            ->fetchAll();
            
        $result = [];

        foreach($records as $row) {
            $result[] = (object) [
                'id' => $row['project_id'],
                'title' => $row['project_title'],
                'description' => $row['project_description'],
                'creation_date' => $row['project_creation_date']
            ];
        }
        
        return $result;
    }
    
    public function getByID($id) {
        $record = $this->_pdo->createQueryBuilder()
            ->select('project_id', 'project_title', 'project_description', 'project_creation_date')
            ->from('project')
            ->where('project_id = :id')
            ->setParameter('id', (int) $id)
            ->execute()
            ->fetch();

            $result = (object) [
                'id' => $record['project_id'],
                'title' => $record['project_title'],
                'description' => $record['project_description'],
                'creation_date' => $record['project_creation_date']
            ];
        
        return $result;
    }
    
    public function getUsers($projectId) {
        $records = $this->_pdo->createQueryBuilder()
            ->select('u.user_id', 'u.user_email')
            ->from('user', 'u')
            ->innerJoin('u', 'project_user', 'pu', 'u.user_id = pu.user_id')
            ->where('pu.project_id = :id')
            ->setParameter('id', (int) $projectId)
            ->execute()
            ->fetchAll();
            
        $result = [];

        foreach($records as $row) {
            $result[] = (object) [
                'id' => $row['user_id'],
                'email' => $row['user_email']
            ];
        }
        
        return $result;
    }
    
    public function totalCount() {
        $count = $this->_pdo->createQueryBuilder()
            ->select('project_id')
            ->from('project')
            ->execute()
            ->rowCount();
        
        return $count;
    }
    
    public function create($project, $users) {
        $values = [
            'project_title' => ':title',
            'project_description' => ':description',
            'project_creation_date' => ':creation_date'
            ];

        $this->_pdo->createQueryBuilder()
            ->insert('project')
            ->values($values)
            ->setParameter('title', $project->title)
            ->setParameter('description', $project->description)
            ->setParameter('creation_date', Utilities\DateTime::dbDateFormat())
            ->execute();
            
        if (empty($users) == false) {
            $this->addUsers($users, $this->_pdo->lastInsertId());
        }
        
        return true;
    }
    
    public function update($project, $users) {
        $this->_pdo->createQueryBuilder()
            ->update('project')
            ->set('project_title', ':title')
            ->set('project_description', ':description')
            ->set('project_creation_date', ':creation_date')
            ->where('project_id = :id')
            ->setParameter('title', $project->title)
            ->setParameter('description', $project->description)
            ->setParameter('creation_date', Utilities\DateTime::dbDateFormat($project->creation))
            ->setParameter('id', (int) $project->id)
            ->execute();
            
        if (empty($users) == false) {
            $this->addUsers($users, (int) $project->id);
        }

        return true;
    }
    
    public function addUsers($users, $projectId) {
        $this->deleteUsers($projectId);
        
        foreach($users as $user) {
            $this->_pdo->createQueryBuilder()
                ->insert('project_user')
                ->values([
                    'project_id' => ':project_id',
                    'user_id' => ':user_id'   
                ])
                ->setParameter('project_id', (int) $projectId)
                ->setParameter('user_id', (int) $user)
                ->execute();
        }
        
        return true;
    }
    
    public function updateUsers($users, $projectId) {
        foreach($users as $user) {
            $this->_pdo->createQueryBuilder()
                ->insert('project_user')
                ->values([
                    'project_id' => ':project_id',
                    'user_id' => ':user_id'
                ])
                ->setParameter('project_id', (int) $projectId)
                ->setParameter('user_id', (int) $user)
                ->execute();
        }
        
        return true;
    }
    
    public function deleteUser($userId, $projectId) {
        $this->_pdo->createQueryBuilder()
            ->delete('project_user')
            ->where('project_id = :project_id')
            ->andWhere('user_id = :user_id')
            ->setParameter('project_id', (int) $projectId)
            ->setParameter('user_id', (int) $userId)
            ->execute();
        
        return true;
    }
    
    public function deleteUsers($projectId) {
        $this->_pdo->createQueryBuilder()
            ->delete('project_user')
            ->where('project_id = :project_id')
            ->setParameter('project_id', (int) $projectId)
            ->execute();
        
        return true;
    }
    
    public function delete($projectId) {
        $this->_pdo->createQueryBuilder()
            ->delete('project')
            ->where('project_id = :project_id')
            ->setParameter('project_id', (int) $projectId)
            ->execute();
        
        return true;
    }
}