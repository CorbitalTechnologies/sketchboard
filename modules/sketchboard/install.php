<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

if (!$CI->db->table_exists(db_prefix() . 'sketchboard')) {
    $CI->db->query(
        'CREATE TABLE `' .  db_prefix() . 'sketchboard` (
             `id` int NOT NULL AUTO_INCREMENT,
            `title` varchar(55) NOT NULL,
            `description` text NOT NULL,
            `board_data` text NOT NULL,
            `created_by` int NOT NULL,
            `shared_to` text,
            `updated_by` int DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';'
    );
}
