<?php
namespace Helloworld\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
    private $_loginForm;
    
    public function loginAction()
    {
        if (!$this->_loginForm)
            throw new \BadMethodCallException('Login Form not yet set!');
        
        if ($this->getRequest()->isPost()) {
            $this->_loginForm->setData($this->getRequest()->getPost());
            
            if ($this->_loginForm->isValid()) {
                var_dump($this->_loginForm->getData());exit;
            } else {
                return new ViewModel(
                    array(
                        'form' => $this->_loginForm
                    )
                );
            }
        } else {
            return new ViewModel(
                array(
                    'form' => $this->_loginForm
                )
            );
        }
    }
    
    public function setLoginForm($loginForm)
    {
        $this->_loginForm = $loginForm;
    }
    
    public function getLoginForm()
    {
        return $this->_loginForm;
    }
}
