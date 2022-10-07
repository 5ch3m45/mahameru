<?php

class Admin_model extends CI_Model
{
    protected $table = 'users';

    function getFirst($id) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('id', $id)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getOneByID($id) {
        return $this->db->select('id, name, email, image, last_login')
            ->from($this->table)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getPaginated($page) {
        $offset = 10 * ($page-1);
        return $this->db->select('id, name, email, image, last_login')
            ->from($this->table)
            ->limit(10, $offset)
            ->get()
            ->result_array();
    }

    function getOneByEmail($email) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('email', $email)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function setForgotPasswordCredential($email, $selector, $token_hashed) {
        return $this->db->update($this->table, [
            'forgotten_password_selector' => $selector,
            'forgotten_password_code' => $token_hashed,
            'forgotten_password_time' => time()
        ], [
            'email' => $email
        ]);
    }

    function getOneByForgotPasswordSelector($selector) {
        return $this->db->select('id, email, forgotten_password_selector, forgotten_password_code, forgotten_password_time')
            ->from($this->table)
            ->where('forgotten_password_selector', $selector)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function updateAdminPassword($id, $hashed_password) {
        return $this->db->update($this->table, [
            'password' => $hashed_password,
            'forgotten_password_code' => '',
            'forgotten_password_time' => '',
        ], [
            'id' => $id
        ]);
    }
}