<?php

namespace FcPhp\SHttp\Interfaces
{

    interface ISEntity
    {
        /**
         * Method to set Id of login
         *
         * @param string $id Id of login
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setId(string $id) :ISEntity;
        /**
         * Method to get Id of login
         *
         * @return string|null
         */
        public function getId();



        /**
         * Method to set Name of login
         *
         * @param string $name Name of login
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setName(string $name) :ISEntity;
        /**
         * Method to get Name of login
         *
         * @return string|null
         */
        public function getName();



        /**
         * Method to set E-mail of login
         *
         * @param string $email E-mail of login
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setEmail(string $email) :ISEntity;
        /**
         * Method to get E-mail of login
         *
         * @return string|null
         */
        public function getEmail();



        /**
         * Method to set User name of login
         *
         * @param string $username User name of login
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setUsername(string $username) :ISEntity;
        /**
         * Method to get User name of login
         *
         * @return string|null
         */
        public function getUsername();



        /**
         * Method to set Type of login
         *
         * @param string|int $type Type of login
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setType($type) :ISEntity;
        /**
         * Method to get Type of login
         *
         * @return string
         */
        public function getType() :string;



        /**
         * Method to set Permissions of login
         *
         * @param array $permissions Permissions of login
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setPermissions(array $permissions) :ISEntity;
        /**
         * Method to get Permissions of login
         *
         * @return array
         */
        public function getPermissions() :array;
        /**
         * Method to check if have access to permission
         *
         * @param string $permission Permission to check
         * @return bool
         */
        public function check(string $permission) :bool;



        /**
         * Method to set Custom data of login
         *
         * @param string $key Key to save content
         * @param array|string $customData Data to save
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setCustomData(string $key, $customData) :ISEntity;
        /**
         * Method to get Custom data of login
         *
         * @param string|null $key Key to find content
         * @return array|null
         */
        public function getCustomData(string $key = null);



        /**
         * Method to set Errors of login
         *
         * @param string $message Message of error
         * @return cPhp\SHttp\Interfaces\ISEntity
         */
        public function setError(string $message) :ISEntity;
        /**
         * Method to get Errors of login
         *
         * @return array
         */
        public function getError() :array;
        /**
         * Method to check if have errors in login
         *
         * @return bool
         */
        public function haveErrors() :bool;
    }
}