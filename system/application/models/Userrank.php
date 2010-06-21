<?php
class Userrank extends DataMapper {

    public function __construct()
    {
        // model constructor
        parent::__construct();
    }

    function getBestUser($limit = 5)
    {
        $types = array(0, 1);
        $bstUsr = $this->where_in('type', $types)->get()->all;
        
        foreach($bstUsr AS $bu)
        {
            if($bu->type == 1)
                $users[$bu->user_id] += (10 * $bu->rank);
            else
                $users[$bu->user_id] += $bu->rank;
        }
        if(is_array($users))
        {
            arsort($users,SORT_NUMERIC);
            $users = array_slice($users, 0,$limit,TRUE);
            $usrMdl = new User_model();
            foreach($users AS $user=>$rank)
            $usersHolder[] = $usrMdl->get_user_by_id($user);
            return $usersHolder;
        }
    }
}
?>
