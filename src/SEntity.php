<?php

namespace FcPhp\SHttp
{
    use FcPhp\SHttp\Interfaces\ISEntity;

    class SEntity implements ISEntity
    {
        /**
         * @var array Types available to login 
         */
        private $types = [
            null => 'guest',
            1    => 'admin',
            2    => 'user',
        ];

        /**
         * @var string Id of login
         */
        private $id = null;

        /**
         * @var string Name of login
         */
        private $name = null;

        /**
         * @var string E-mail of login
         */
        private $email = null;

        /**
         * @var string User name of login
         */
        private $username = null;

        /**
         * @var string Type of login
         */
        private $type = null;

        /**
         * @var string Permissions of login
         */
        private $permissions = [];

        /**
         * @var string Custom data of login
         */
        private $customData = [];

        /**
         * @var string Errors of login
         */
        private $error = [];

        /**
         * @var strint Timestamp created
         */
        private $created;

        /**
         * @var int Timestamp expires
         */
        private $expires;

        /**
         * Method to construct instance of Security Entity
         *
         * @param int $expires Timestamp expires Security Entity
         * @return void
         */
        public function __construct(int $expires = 84000)
        {
            $this->created = time();
            $this->expires = $expires;
            $this->expires = $this->created + $this->expires;
        }

        /**
         * Method to set Id of login
         *
         * @param string $id Id of login
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setId(string $id) :ISEntity
        {
            $this->id = $id;
            return $this;
        }

        /**
         * Method to get Id of login
         *
         * @return string|null
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Method to set Name of login
         *
         * @param string $name Name of login
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setName(string $name) :ISEntity
        {
            $this->name = $name;
            return $this;
        }

        /**
         * Method to get Name of login
         *
         * @return string|null
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * Method to set E-mail of login
         *
         * @param string $email E-mail of login
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setEmail(string $email) :ISEntity
        {
            $this->email = $email;
            return $this;
        }

        /**
         * Method to get E-mail of login
         *
         * @return string|null
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * Method to set User name of login
         *
         * @param string $username User name of login
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setUsername(string $username) :ISEntity
        {
            $this->username = $username;
            return $this;
        }

        /**
         * Method to get User name of login
         *
         * @return string|null
         */
        public function getUsername()
        {
            return $this->username;
        }

        /**
         * Method to set Type of login
         *
         * @param string|int $type Type of login
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setType($type) :ISEntity
        {
            array_walk($this->types, function($name, $index) use ($type) {
                if($type === $name){
                    $this->type = $index;
                }
            });
            if(is_null($this->type)) {
                if(isset($this->types[$type])) {
                    $this->type = $type;
                }
            }
            return $this;
        }

        /**
         * Method to get Type of login
         *
         * @return string
         */
        public function getType() :string
        {
            return $this->types[$this->type];
        }

        /**
         * Method to set Permissions of login
         *
         * @param array $permissions Permissions of login
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setPermissions(array $permissions) :ISEntity
        {
            $this->permissions = $permissions;
            return $this;
        }

        /**
         * Method to get Permissions of login
         *
         * @return array
         */
        public function getPermissions() :array
        {
            return $this->permissions;
        }

        /**
         * Method to set Custom data of login
         *
         * @param string $key Key to save content
         * @param array|string $customData Data to save
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setCustomData(string $key, $customData) :ISEntity
        {
            array_dot($this->customData, $key, $customData);
            return $this;
        }

        /**
         * Method to get Custom data of login
         *
         * @param string|null $key Key to find content
         * @return array|null
         */
        public function getCustomData(string $key = null)
        {
            return array_dot($this->customData, $key);
        }

        /**
         * Method to check if have access to permission
         *
         * @param string $permission Permission to check
         * @return bool
         */
        public function check(string $permission) :bool
        {
            return ('admin' === $this->types[$this->type] || in_array($permission, $this->permissions));
        }

        /**
         * Method to set Errors of login
         *
         * @param string $message Message of error
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setError(string $message) :ISEntity
        {
            $this->error[] = $message;
            return $this;
        }

        /**
         * Method to get Errors of login
         *
         * @return array
         */
        public function getError() :array
        {
            return $this->error;
        }

        /**
         * Method to check if have errors in login
         *
         * @return bool
         */
        public function haveErrors() :bool
        {
            return count($this->error) > 0;
        }

        /**
         * Method to check if this Security Entity has expired
         *
         * @return bool
         */
        public function isExpired() :bool
        {
            return ($this->expires < time());
        }
    }
}