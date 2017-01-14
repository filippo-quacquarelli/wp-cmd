<?php
/**
 * Plugin Name: WP CMD
 * Description: wp-cli Interface
 * Author: Filippo Quacquarelli
 * Version: 0.5
 */

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::add_command('cmd', 'WP_CLI_CMD', array( 'when' => 'before_wp_load' ));
}

/**
 * Quickly manage WordPress installations.
 *
 * Usages:
 *
 * wp cmd copy <dest> --server_path
 *
 */
 
class WP_CLI_CMD {
    
    private $db_user = DB_USER;
    private $db_name = DB_NAME;
    private $db_pass = DB_PASSWORD;
    private $success = "
                            __
                           /  \
                          |    |
            _             |    |
          /' |            | _  |
         |   |            |    |
         | _ |            |    |
         |   |            |    |
         |   |        __  | _  |
         | _ |  __   /  \ |    |
         |   | /  \ |    ||    |
         |   ||    ||    ||    |       _---.
         |   ||    ||    |. __ |     ./     |
         | _. | -- || -- |    `|    /      //
         |'   |    ||    |     |   /`     (/
         |    |    ||    |     | ./       /
         |    |.--.||.--.|  __ |/       .|
         |  __|    ||    |-'            /
         |-'   \__/  \__/             .|
         |       _.-'                 /
         |   _.-'      /             |
         |            /             /
         |           |             /
         `           |            /
          \          |          /'
           |          `        /
            \                .'
            |                |
            |                |
            |                |
            |                |

    __                         __                           
   / /_  __  ______  ____     / /___ __   ______  _________ 
  / __ \/ / / / __ \/ __ \   / / __ `/ | / / __ \/ ___/ __ \
 / /_/ / /_/ / /_/ / / / /  / / /_/ /| |/ / /_/ / /  / /_/ /
/_.___/\__,_/\____/_/ /_/  /_/\__,_/ |___/\____/_/   \____/ 
                                                            
        ";

    static private function get_url() {
        $array_url = array();

        $old_domain = get_site_url();

        $data_domain = parse_url($old_domain);

        $array_url['protocol'] = $data_domain['scheme'];

        $array_url['host'] = $data_domain['host'];

        $array_url['base_url'] = $array_url['protocol'] . '://' . $array_url['host'];

        $array_url['old_domain'] = $old_domain;

        return $array_url;
    }

    /**
     * Copy wordpress site
     *
     * ## OPTIONS
     *
     * <dest>
     * : The destination for the new site install.
     *
     * [--server_path] 
     * : server_path eg: /var/www/
     *
     * [--db_name] 
     * : db_name eg: newsite
     *
     * [--db_user] 
     * : db_user eg: root
     *
     * [--db_pass] 
     * : db_pass eg: password
     */

    public function copy( $args, $assoc_args ) {

        $foldername = $args[0];

        $config_param_foldername = explode('.', $foldername);

        if ( count($config_param_foldername) <= 1 ) return WP_CLI::log( "Il dominio dovrebbe essere nel seguente formato: newsite.com" );

        $server_path = $assoc_args['server_path'];

        if ( ! $server_path ) return WP_CLI::log( "error: specificare server path, eg: --server_path=/var/www/" );

        $server_path = realpath($server_path);

        $path = $server_path . '/' . $foldername;

        $routes = $this::get_url();

        $db_name = $assoc_args['db_name'];

        if ( ! $db_name ) $db_name = $config_param_foldername[0];

        $db_user = $assoc_args['db_user'];

        if ( ! $db_user ) $db_user = $this->db_user;

        $db_pass = $assoc_args['db_pass'];

        if ( ! $db_pass ) $db_pass = $this->db_pass;

        $copy_folder = "cp -rvfa ./ ../%s";

        $delete_config = "find ../%s/wp-config.php -type f -exec rm {} +";
        
        $config_param = "core config --path=$path --dbname=$db_name --dbuser=$db_user --dbpass=$db_pass";
        
        $create_db = "db create --path=$path";

        $import_db = "db import $this->db_name.sql --path=$path";

        $replace_db = "search-replace '" . $routes['old_domain'] . "' '". $routes['base_url'] ."/" . $foldername . "' --skip-columns=guid --path=$path";

        $options = array(
            'exit_error' => true, // Halt script execution on error.
        );

        WP_CLI::log( 'Esportazione db ...' );
        
        WP_CLI::runcommand( 'db export', $options );

        WP_CLI::log( 'Copia sito ...' );
        
        WP_CLI::launch( \WP_CLI\Utils\esc_cmd( $copy_folder, $foldername ) );

        WP_CLI::launch( \WP_CLI\Utils\esc_cmd( $delete_config, $foldername ) );

        WP_CLI::log( 'Creazione wp-config ...' );

        WP_CLI::runcommand( $config_param, $options );

        WP_CLI::log( 'Creazione db ...' );

        WP_CLI::runcommand( $create_db, $options );

        WP_CLI::log( 'Importazione db ...' );

        WP_CLI::runcommand( $import_db, $options );

        WP_CLI::log( 'Sostituzione stringhe nel db ...' );

        WP_CLI::runcommand( $replace_db, $options );

        WP_CLI::success( $this->success );
    }
}