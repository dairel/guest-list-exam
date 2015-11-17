<?php
class TaskService {
    
    public static function listguests() {
        $db = ConnectionFactory::getDB();
        $guests = array();
        
        foreach($db->guests() as $guests) {
           $guests[] = array (
               'id' => $guests['id'],
               'name' => $guests['name'],
               'email' => $guests['email']
           ); 
        }
        
        return $guests;
    }
    
    public static function getById($id) {
        $db = ConnectionFactory::getDB();
        return $db->guests[$id];
    }
    
    public static function add($newguests) {
        $db = ConnectionFactory::getDB();
        $task = $db->tasks->insert($newguests);
        return $guests;
    }
    
    public static function update($updatedguests) {
        $db = ConnectionFactory::getDB();
        $guests = $db->tasks[$updatedguests['id']];
        
        if($guests) {
            $guests['name'] = $updatedguests['name'];
            $guests['email'] = $updatedTask['email'];
            $guests->update();
            return true;
        }
        
        return false;
    }
    

}
?>