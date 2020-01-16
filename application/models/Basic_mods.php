<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Basic_mods extends CI_Model
{
    public function getUsers()
    {
        $query = "SELECT a.id, a.name, a.fullname, a.email, b.role, a.role_id, a.is_active FROM user a, user_role b WHERE a.role_id = b.id";

        return $this->db->query($query)->result_array();
    }

    public function getBreadcrumb($title)
    {
        $query = "SELECT user_menu.group, user_menu.menu, user_sub_menu.title
                  FROM user_menu, user_sub_menu
                  WHERE user_menu.id = user_sub_menu.menu_id AND user_sub_menu.title= '$title' ";

        return $this->db->query($query)->row_array();
    }

    public function getSubMenu()
    {
        $query = "SELECT `user_sub_menu`.*,`user_menu`.`menu` FROM `user_sub_menu` JOIN `user_menu`
         ON `user_sub_menu`.`menu_id`=`user_menu`.`id`";

        return $this->db->query($query)->result_array();
    }

    public function deleteData($name, $id)
    {
        if ($name === "menu"){
            $query = "DELETE from user_menu where id = $id ";
        }
        elseif ($name === "submenu"){
            $query = "DELETE from user_sub_menu where id = $id ";
        }
        elseif ($name === "role"){
            $del_access_menu = "DELETE from user_access_menu where role_id = $id ";
            $this->db->query($del_access_menu);

            $query = "DELETE from user_role where id = $id ";
        }
        $this->db->query($query);

        return $query;
    }

    public function insertData($name, $data)
    {
        if ($name === "menu"){
            $this->db->insert('user_menu', $data);

            $idMenu = $this->db->get_where('user_menu',$data)->row_array();
            $mstr_access = [
                'role_id' => 1,
                'menu_id' => $idMenu['id']
            ];
            $this->db->insert('user_access_menu', $mstr_access);
        }
        elseif ($name === "submenu"){
            $this->db->insert('user_sub_menu', $data);
        }
        elseif ($name === "role"){
            $role = [ 'role' => $data ];
            $this->db->insert('user_role', $role);

            $idRole = $this->db->get_where('user_role', ['role' => $data])->row_array();
            $role_access = [
                'role_id' => $idRole['id'],
                'menu_id' => '2'
            ];
            $this->db->insert('user_access_menu', $role_access);
        }

        return 1;
    }
}
