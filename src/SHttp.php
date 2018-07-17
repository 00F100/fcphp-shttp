<?php

namespace FcPhp\SHttp
{
    use FcPhp\Session\Interfaces\ISession;
    use FcPhp\SHttp\Interfaces\ISHttp;
    use FcPhp\SHttp\Interfaces\ISEntity;

    class SHttp implements ISHttp
    {
        const SHTTP_SERVER_KEY = 'Authorization';
        const SHTTP_SESSION_KEY = 'shttp';

        /**
         * @var FcPhp\Session\Interfaces\ISession Instance of Session
         */
        private $session;
        private $entity;
        private $server;

        private $authHeader;
        private $authSession;

        private $authHeaderCallback;
        private $authSessionCallback;
        private $authUserPassCallback;
        private $authGuestCallback;

        /**
         * Method to construct instance of Security HTTP
         *
         * @param FcPhp\Session\Interfaces\ISession $session Instance of Session
         * @return void
         */
        public function __construct(array $post, array $server, ISession $session, ISEntity $entity)
        {
            $this->authUserPass = $post;
            $this->server = $server;
            $this->session = $session;
            $this->entity = $entity;
        }

        public function get() :ISEntity
        {
            $this->authHeader = isset($this->server[self::SHTTP_SERVER_KEY]) ? $this->server[self::SHTTP_SERVER_KEY] : null;
            $this->authSession = $this->session->get(self::SHTTP_SESSION_KEY);
            return $this->execute();
        }

        public function callback(string $key, $clousure) :ISHttp
        {
            if(property_exists($this, $key)) {
                $this->{$key} = $clousure;
            }
            return $this;
        }

        private function execute() :ISEntity
        {
            if(!empty($this->authHeader)) {
                return $this->authHeader();
            }
            
            if(!empty($this->authSession)) {
                return $this->authSession();
            }

            if(count($this->authUserPass) > 0){
                return $this->authUserPass();
            }

            return $this->authGuest();
        }

        private function authHeader() :ISEntity
        {
            $authHeaderCallback = $this->authHeaderCallback;
            return $authHeaderCallback($this->entity, $this->authHeader);
        }

        private function authSession() :ISEntity
        {
            $authSessionCallback = $this->authSessionCallback;
            return $authSessionCallback($this->entity, $this->authSession);
        }

        private function authUserPass() :ISEntity
        {
            $authUserPassCallback = $this->authUserPassCallback;
            return $authUserPassCallback($this->entity, $this->authUserPass);
        }

        private function authGuest() :ISEntity
        {
            $authGuestCallback = $this->authGuestCallback;
            return $authGuestCallback($this->entity);
        }
    }
}