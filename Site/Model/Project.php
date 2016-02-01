<?php
namespace Site\Model;

use Site\Library\Utilities as Utilities;
use \Doctrine\DBAL as DBAL;
use Site\Library\Debug as Debug;

class Project extends DAL
{
    public function create($project, $users) {
        $values = [
            'project_title' => ':title',
            'project_description' => ':description',
            'project_creation_date' => ':creation_date'
            ];

        $this->_pdo->createQueryBuilder()
            ->insert('project')
            ->values($values)
            ->setParameter('title', $project['title'])
            ->setParameter('description', $project['description'])
            ->setParameter('creation_date', Utilities\DateTime::getDBDateFormat())
            ->execute();
            
            
        $this->addUsers($users, $this->_pdo->lastInsertId());

        return true;
    }
    
    public function update($project) {
        $this->_pdo->createQueryBuilder()
            ->update('project')
            ->set('project_title', ':title')
            ->set('project_description', ':description')
            ->where('project_id = :id')
            ->setParameter('title', $project['title'])
            ->setParameter('description', $project['description'])
            ->setParameter('id', $project['id'])
            ->execute();

        return true;
    }
    
    public function addUsers($users, $projectId) {
        foreach($users as $user) {
            $this->_pdo->createQueryBuilder()
                ->insert('project_user')
                ->values([
                    'project_id' => ':project_id',
                    'user_id' => ':user_id'   
                ])
                ->setParameter('project_id', $projectId)
                ->setParameter('user_id', $user)
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
                ->setParameter('project_id', $projectId)
                ->setParameter('user_id', $user)
                ->execute();
        }
        
        return true;
    }
    
    public function deleteUser($userId, $projectId) {
        $this->_pdo->createQueryBuilder()
            ->delete('project_user')
            ->where('project_id = :project_id')
            ->andWhere('user_id = :user_id')
            ->setParameter('project_id', $projectId)
            ->setParameter('user_id', $userId)
            ->execute();
        
        return true;
    }
    
    public function delete($projectId) {
        $this->_pdo->createQueryBuilder()
            ->delete('project')
            ->where('project_id = :project_id')
            ->setParameter('project_id', $projectId)
            ->execute();
        
        return true;
    }
}