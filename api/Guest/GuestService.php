<?php
class TaskService {
      public static function listGuest() {
        $db = ConectionFactory::getDB();
        $guest = array();
        
        foreach($db->guests() as $guest) {
           $guests[] = array (
               'id' => $guests['id'],
               'nome' => $guests['nome'],
               'email' => $guests['email']
           ); 
        }
        
        return $guests;
    }
       public static function add($newguests) {
         $db = ConnectionFactory::getDB();
         $guests = $db->guests->insert($newGuest);
        
         return $guest;
    }
    
    public static function update($updatedguest) {
        $db = ConnectionFactory::getDB();
        $guests = $db->guests[$updatedguest['id']];
        
        if($guests) {
            $guests['name]'] = $updatedguest['name'];
            $guests['email'] = $updatedguest['email'];
            return true;
        }
        
        return false;
    }
}
?>