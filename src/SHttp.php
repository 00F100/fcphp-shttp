<?php

namespace FcPhp\SHttp
{
    use FcPhp\Session\Interfaces\ISession;
    use FcPhp\SHttp\Interfaces\ISHttp;
    use FcPhp\SHttp\Interfaces\ISEntity;

    class SHttp implements ISHttp
    {

        const SHTTP_SERVER_KEY = 'Authorization';
        const SHTTP_SESSION_KEY = 'sentity';

        /**
         * @var FcPhp\Session\Interfaces\ISession Instance of Session
         */
        private $session;

        /**
         * @var FcPhp\SHttp\Interfaces\ISEntity Instance of SEntity
         */
        private $entity;

        /**
         * @var array $_SERVER params
         */
        private $server;

        /**
         * @var string Content of header auth
         */
        private $authHeader;

        /**
         * @var array Content of session auth
         */
        private $authSession;

        /**
         * @var mixed Clousure header auth
         */
        private $authHeaderCallback;

        /**
         * @var mixed Clousure session auth
         */
        private $authSessionCallback;

        /**
         * @var mixed Clousure user and password auth
         */
        private $authUserPassCallback;

        /**
         * @var mixed Clousure guest auth
         */
        private $authGuestCallback;

        /**
         * Method to construct instance of Security HTTP
         *
         * @param array $post $_POST params
         * @param array $server $_SERVER params
         * @param FcPhp\SHttp\Interfaces\ISEntity $entity Instance of SEntity
         * @param FcPhp\Session\Interfaces\ISession $session Instance of Session
         * @return void
         */
        public function __construct(array $post, array $server, ISEntity $entity, ISession $session = null)
        {
            $this->authUserPass = $post;
            $this->server = $server;
            $this->session = $session;
            $this->entity = $entity;
        }

        /**
         * Method to get SEntity of user
         *
         * @return FcPhp\SHttp\Interfaces\ISEntity
         */
        public function get() :ISEntity
        {
            $this->authHeader = isset($this->server[self::SHTTP_SERVER_KEY]) ? $this->server[self::SHTTP_SERVER_KEY] : null;
            if($this->session instanceof ISession) {
                $this->authSession = $this->session->get(self::SHTTP_SESSION_KEY);
            }
            return $this->execute();
        }

        /**
         * Method to configure callback auth
         *
         * @param string $key Key of callback
         * @param mixed $clousure Clousure to run
         * @return FcPhp\SHttp\Interfaces\ISHttp
         */
        public function callback(string $key, $clousure) :ISHttp
        {
            if(property_exists($this, $key)) {
                $this->{$key} = $clousure;
            }
            return $this;
        }

        /**
         * Method to execute correct clousure
         *
         * @return FcPhp\SHttp\Interfaces\ISEntity
         */
        private function execute() :ISEntity
        {
            if(!is_null($this->authHeader)) {
                return $this->authHeader();
            }
            if(!is_null($this->authSession)) {
                return $this->authSession();
            }
            if(count($this->authUserPass) > 0){
                return $this->authUserPass();
            }
            return $this->authGuest();
        }

        /**
         * Method to auth header
         *
         * @return FcPhp\SHttp\Interfaces\ISEntity
         */
        private function authHeader() :ISEntity
        {
            $authHeaderCallback = $this->authHeaderCallback;
            return $authHeaderCallback($this->entity, $this->authHeader);
        }

        /**
         * Method to auth session
         *
         * @return FcPhp\SHttp\Interfaces\ISEntity
         */
        private function authSession() :ISEntity
        {
            $authSessionCallback = $this->authSessionCallback;
            return $authSessionCallback($this->entity, $this->authSession);
        }

        /**
         * Method to auth post user and password
         *
         * @return FcPhp\SHttp\Interfaces\ISEntity
         */
        private function authUserPass() :ISEntity
        {
            $authUserPassCallback = $this->authUserPassCallback;
            return $authUserPassCallback($this->entity, $this->authUserPass);
        }

        /**
         * Method to auth guest
         *
         * @return FcPhp\SHttp\Interfaces\ISEntity
         */
        private function authGuest() :ISEntity
        {
            $authGuestCallback = $this->authGuestCallback;
            return $authGuestCallback($this->entity);
        }
    }
}