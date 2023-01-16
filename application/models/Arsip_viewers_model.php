<?php

class Arsip_viewers_model extends CI_Model
{
    protected $table = 'tbl_arsip_viewers';

    function addViewer($arsip_id, $date) {
        // dapatkan data hari itu jika ada
        $today_exist = $this->db->select('id, viewers')
            ->from($this->table)
            ->where('arsip_id', $arsip_id)
            ->where('date', $date)
            ->limit(1)
            ->get()
            ->row_array();
        if(!empty($today_exist)) {
            return $this->db->where('id', $today_exist['id'])
                ->update($this->table, [
                    'viewers' => $today_exist['viewers']+1,
                    'updated_at' => date('c')
                ]);
        } else {
            return $this->db->insert($this->table, [
                'arsip_id' => $arsip_id,
                'date' => $date,
                'viewers' => 1,
                'created_at' => date('c'),
                'updated_at' => date('c')
            ]);
        }
    }

    function getArsipHistoricalViewerByRange($arsip_id, $start_date, $end_date) {
        return $this->db->select('viewers')
            ->from($this->table)
            ->where('arsip_id', $arsip_id)
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->get()
            ->result_array();
    }

    function getAllHistoricalViewerByRange($start_date, $end_date) {
        return $this->db->select('date, SUM(viewers) as viewers')
            ->from($this->table)
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->group_by('date')
            ->get()
            ->result_array();
    }
}