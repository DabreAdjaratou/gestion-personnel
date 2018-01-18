<?php

namespace User\Controller;

use User\Model\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Form\UserForm;
use User\Model\User;

class UserController extends AbstractActionController {

    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(UserTable $table) {
        $this->table = $table;
    }

    public function indexAction() {
        return new ViewModel([
            'users' => $this->table->fetchAll(),
        ]);
    }

     public function addAction()
    {
        $form = new UserForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $user = new User();
//        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());
        
        

        if (! $form->isValid()) {
          
            return ['form' => $form];
        }

        $user->exchangeArray($form->getData());
        $this->table->saveUser($user);
        return $this->redirect()->toRoute('user');
    }


    public function editAction() {
        
    }

    public function viewAction() {
        
    }

    public function changePasswordAction() {
        
    }

    public function resetPasswordAction()
    {
    
}

}
