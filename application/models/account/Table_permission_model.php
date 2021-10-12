<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Table_permission_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
	}

	public function generate(){	
		$this->db->distinct();
        $this->db->where('auth_routes.parent_id', null);
        $this->db->order_by('auth_routes.id', 'ASC');
        $this->db->order_by('auth_routes.sort', 'ASC');
        $data = $this->db->get('auth_routes')->result();
        if (!is_null($data)) {
            foreach ($data as $row) {
                $this->tablePermissionRow($row);
            }
        }
	}

	private function tablePermissionRow($parent, $level = 0, $has_child = false) {

        $this->db->distinct();
        $this->db->where('auth_routes.parent_id', $parent->id);
        
        $this->db->order_by('auth_routes.name', 'ASC');
        $data = $this->db->get('auth_routes')->result();

        $menu_id = $parent->id;
        $parentId = $parent->parent_id ? $parent->parent_id : $parent->id;

        $hasChild = $has_child ? "is_child" : "is_parent";
        $isSecure = null;
        $isChecked = null;
        $checkbox = "<input type='checkbox' name='routes[]' value='" . $menu_id . "' id='menu" . $menu_id . "' class=' menu  " . $hasChild . " parent" . $parentId . "' data-menu-id='" . $menu_id . "'  data-parent-id='" . $parentId . "' " . $isChecked . "  />";
        $menuName = $has_child ? "" . $this->checkBoxWrapper($checkbox, $parent->name, $level) : "" . $this->checkBoxWrapper($checkbox, $parent->name, $level) . "";

        if (count($data) > 0) {
            if (isset($parent->url) && !is_null($parent->url)) {

                echo "
                    <tr>
                        <td>" . $menuName . "</td>
                        <td class='text-center'>" . $this->checkBoxWrapper("<input type='checkbox' id='can_view" . $menu_id . "' name='can_view" . $menu_id . "' value='1'  class=' permission view'  data-menu-id='" . $menu_id . "'  data-parent-id='" . $parentId . "' " . $isChecked . "  />", null, 0, false) . "</td>
                        <td class='text-center'>" . $this->checkBoxWrapper("<input type='checkbox' id='can_add" . $menu_id . "' name='can_add" . $menu_id . "' value='1'  class=' permission create'  data-menu-id='" . $menu_id . "'  data-parent-id='" . $parentId . "' " . $isChecked . "  />", null, 0, false) . "</td>
                        <td class='text-center'>" . $this->checkBoxWrapper("<input type='checkbox' id='can_edit" . $menu_id . "' name='can_edit" . $menu_id . "' value='1'  class=' permission edit'  data-menu-id='" . $menu_id . "'  data-parent-id='" . $parentId . "' " . $isChecked . "  />", null, 0, false) . "</td>
                        <td class='text-center'>" . $this->checkBoxWrapper("<input type='checkbox' id='can_delete" . $menu_id . "' name='can_delete" . $menu_id . "' value='1'  class=' permission delete'  data-menu-id='" . $menu_id . "'  data-parent-id='" . $parentId . "' " . $isChecked . "  />", null, 0, false) . "</td>
                    </tr>
                ";
            } else {
                echo
                "<tr>
                    <td>" . $menuName . "</td>
					<td class='text-center'><i class='fa fa fa-ban'></i></td>
					<td class='text-center'><i class='fa fa fa-ban'></i></td>
					<td class='text-center'><i class='fa fa fa-ban'></i></td>
                    <td class='text-center'><i class='fa fa fa-ban'></i></td>
				</tr>";
            }
            $level++;
            foreach ($data as $row) {
                $this->tablePermissionRow($row, $level, true);
            }
        } else {
            if (isset($parent->url) && !is_null($parent->url)) {

                echo "
                    <tr class='" . $isSecure . "'>
                        <td>" . $menuName . "</td>
                        <td class='text-center'>" . $this->checkBoxWrapper("<input type='checkbox' id='can_view" . $menu_id . "' name='can_view" . $menu_id . "' value='1'  class=' permission view'  data-menu-id='" . $menu_id . "'  data-parent-id='" . $parentId . "' " . $isChecked . "  />", null, 0, false) . "</td>
                        <td class='text-center'>" . $this->checkBoxWrapper("<input type='checkbox' id='can_add" . $menu_id . "' name='can_add" . $menu_id . "' value='1'  class=' permission create'  data-menu-id='" . $menu_id . "'  data-parent-id='" . $parentId . "' " . $isChecked . "  />", null, 0, false) . "</td>
                        <td class='text-center'>" . $this->checkBoxWrapper("<input type='checkbox' id='can_edit" . $menu_id . "' name='can_edit" . $menu_id . "' value='1'  class=' permission edit'  data-menu-id='" . $menu_id . "'  data-parent-id='" . $parentId . "' " . $isChecked . "  />", null, 0, false) . "</td>
                        <td class='text-center'>" . $this->checkBoxWrapper("<input type='checkbox' id='can_delete" . $menu_id . "' name='can_delete" . $menu_id . "' value='1'  class=' permission delete'  data-menu-id='" . $menu_id . "'  data-parent-id='" . $parentId . "' " . $isChecked . "  />", null, 0, false) . "</td>
                    </tr>
                ";
            } else {
                echo
                "<tr>
                    <td>" . $menuName . "</td>
					<td class='text-center'><i class='fa fa fa-ban'></i></td>
					<td class='text-center'><i class='fa fa fa-ban'></i></td>
					<td class='text-center'><i class='fa fa fa-ban'></i></td>
					<td class='text-center'><i class='fa fa fa-ban'></i></td>
                    <td class='text-center'><i class='fa fa fa-ban'></i></td>
				</tr>";
            }
        }
	}
	
	private function createSpace($param = null) {
        $html = "&nbsp&nbsp";
        $max = $param * 5;
        for ($i = 0; $i < $max; $i++) {
            $html .= "&nbsp;";
        }
        return $html;
    }

    private function checkBoxWrapper($checkbox, $name = null, $space = 0, $withIcon = true) {
        if ($withIcon) {
            return '
                ' . $this->createSpace($space) . '<i class="fa fa-arrow-right"></i>&nbsp;' . $checkbox . '&nbsp;&nbsp;&nbsp;' . $name . '
            ';
        } else {
            return $checkbox;
        }
    }

}
