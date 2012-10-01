<?php
namespace Helloworld\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
    private $_loginForm;
    private $_authService;
    
    public function loginAction()
    {
        if ($this->_authService->hasIdentity()) {
            return new ViewModel(
                array(
                    'loginSuccess' => true,
                    'userLoggedIn' => $this->_authService->getIdentity()
                )
            );
        }
        
        if (!$this->_loginForm)
            throw new \BadMethodCallException('Login Form not yet set!');
        if (!$this->_authService)
            throw new \BadMethodCallException('Auth Service not yet set!');

        
        if ($this->getRequest()->isPost()) {
            $this->_loginForm->setData($this->getRequest()->getPost());
            
            if ($this->_loginForm->isValid()) {
                $data = $this->_loginForm->getData();
                $this->_authService->getAdapter()->setIdentity($data['username']);
                $this->_authService->getAdapter()->setCredential($data['password']);
                $authResult = $this->_authService->authenticate();
                
                if (!$authResult->isValid()) {
                    return new ViewModel(
                        array(
                            'form' => $this->_loginForm,
                            'loginError' => true
                        )
                    ); 
                } else {
                    return new ViewModel(
                        array(
                            'loginSuccess' => true,
                            'userLoggedIn' => $authResult->getIdentity()
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
        } else {
            return new ViewModel(
                array(
                    'form' => $this->_loginForm
                )
            );
        }
    }
    
    public function logoutAction()
    {
        if ($this->_authService->hasIdentity()) {
            $this->_authService->clearIdentity();
        }
        
        $this->redirect()->toUrl('/login');
    }

    public function setLoginForm($loginForm)
    {
        $this->_loginForm = $loginForm;
    }
    
    public function getLoginForm()
    {
        return $this->_loginForm;
    }
    
    public function setAuthService($authService)
    {
        $this->_authService = $authService;
    }
    
    public function getAuthService($authService)
    {
        return $this->_authService;
    }
}
