<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class My_Model extends CI_Model
{
    private $_table;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper('inflector');
        
        if ( ! $this->_table)
        {
            $this->_table = strtolower( plural( str_replace('_model', '', get_class($this) ) ) );
        }
    }
    
    public function get()
    {
        $args = func_get_args();
        if ( count($args) > 1 || is_array($args[0]) ) {
            $this->db->where($args);
        } else {
            $this->db->where('id', $args[0]);
        }
        return $this->db->get($this->_table)->row();
    }
    
    public function get_all($where)
    {
        $args = func_get_args();
        if ( count($args) > 1 || is_array($args[0]) ) {
            $this->db->where($args);
        } else {
            $this->db->where('id', $args[0]);
        }
        return $this->db->get($this->_table)->result();
    }
    
    public function insert($data)
    {
        if ( $data['created'] || $data['modified'] ) {
            $data['created'] = $data['modified'] = date('Y-m-d H:i:s');
        }
        
        $success = $this->db->insert($this->_table, $data);
        if ($success) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }
    
    public function update()
    {
        $args = func_get_args();
        if ( $args[1]['modified'] ) {
            $args[1]['modified'] = date('Y-m-d H:i:s');
        }
        
        if (is_array($args[0])) {
            $this->db->where($args);
        } else {
            $this->db->where('id', $args[0]);
        }
        return $this->db->update($this->_table, $args[1]);
    }
    
    public function delete()
    {
        return ;
        
        // 이 delete 는 사용하지 않음 : 실제로 delete 시킬일 없음
        $args = func_get_args();
        if (count($args) > 1 || is_array($args[0])) {
            $this->db->where($args);
        } else {
            $this->db->where('id', $args[0]);
        }
        return $this->db->delete($this->_table);
    }
}

?>
