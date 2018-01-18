<?php

namespace User\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class UserTable {

    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        return $this->tableGateway->select();
    }

    public function getUser($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException(sprintf(
                    'Could not find row with identifier %d', $id
            ));
        }

        return $row;
    }

    public function saveUser(\User\Model\User $User) {
        
//        if($this->checkUserExists($User['email'])) {
//        throw new \Exception("User with email address " . 
//                    $User['$email'] . " already exists");
//    }
        
        
    $passwordHash = password_hash(($User->password) , PASSWORD_DEFAULT);        
    $currentDate = date('Y-m-d H:i:s');
        
        $data = [
            'email' => $User->email,
            'full_name' => $User->full_name,
            'password' => $passwordHash,
            'status' => $User->status,
            'date_created' => $currentDate,
            'pwd_reset_token' => $User->pwd_reset_token,
            'pwd_reset_token_creation_date' => $User->pwd_reset_token_creation_date
        ];

        $id = (int) $User->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (!$this->getUser($id)) {
            throw new RuntimeException(sprintf(
                    'Cannot update User with identifier %d; does not exist', $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteUser($id) {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
    
    
    public function validatePassword($user, $password) 
{
    $bcrypt = new Bcrypt();
    $passwordHash = $user->getPassword();
    
    if ($bcrypt->verify($password, $passwordHash)) {
        return true;
    }
    
    return false;
}

}
