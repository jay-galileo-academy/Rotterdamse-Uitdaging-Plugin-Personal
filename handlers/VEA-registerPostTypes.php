<?php 
/**
 * @package VraagEnAanbod
 */

class VEAregisterPostTypes
{

    function __construct() {
        add_action('init', [$this, 'registerPostType']);
        add_filter( 'manage_vraag-en-aanbod_posts_columns', [$this, 'customTableHead'] );
        add_action( 'manage_vraag-en-aanbod_posts_custom_column', [$this, 'customTableContent'], 10, 2 );
        add_action( 'manage_edit-vraag-en-aanbod_sortable_columns', [$this, 'customSortableColumns']);
        add_action( 'pre_get_posts', [$this, 'veaOrderby'] );
        add_action( 'restrict_manage_posts', [$this, 'veaCustomFilter'], 10, 1);
        add_filter('parse_query', [$this, 'veaCustomFilterQuery']);
    }
    
    function registerPostType() {
        register_post_type( 'vraag-en-aanbod', [
            'public' => true,
            'label' => 'Vraag en Aanbod',
            'menu_icon' => 'dashicons-buddicons-pm',
            'supports' => array('title', 'thumbnail'),
            'has_archive' => true,
        ]);
    }

    function veaCustomFilter($post_type) {
        if ('vraag-en-aanbod' !== $post_type) {
            return;
        }

        $meta_key = '_vraag_en_aanbod_categorie';
        $vea_options = array(
            '' => __('Alle categorieën', 'textdomain'),
            'handjes' => __('Handjes', 'textdomain'),
            'kennis' => __('Kennis', 'textdomain'),
            'diensten' => __('Diensten', 'textdomain'),
            'producten' => __('Producten', 'textdomain'),
            'tickets' => __('Tickets', 'textdomain'),
            'anders' => __('Anders', 'textdomain')
        );

        echo "<select name='$meta_key' id='$meta_key' class='postform'>";
            foreach($vea_options as $value => $name) {
                printf(
                    '<option value="%1$s" %2$s>%3$s</option>',
                    esc_attr($value),
                    ( ( isset( $_GET[$meta_key] ) && ( $_GET[$meta_key] === $value ) ) ? ' selected="selected"' : '' ),
                    esc_html($name)
                );
            };
        echo '</select>';
    }

    function veaCustomFilterQuery($query) {
        global $pagenow;

        $meta_key = '_vraag_en_aanbod_categorie';
        $vea_options = array(
            '' => __('Alle categorieën', 'textdomain'),
            'handjes' => __('Handjes', 'textdomain'),
            'kennis' => __('Kennis', 'textdomain'),
            'diensten' => __('Diensten', 'textdomain'),
            'producten' => __('Producten', 'textdomain'),
            'tickets' => __('Tickets', 'textdomain'),
            'anders' => __('Anders', 'textdomain')
        );
        $valid_status = array_keys($vea_options);
        $status = (! empty($_GET[$meta_key]) && in_array($_GET[$meta_key],$valid_status)) ? $_GET[$meta_key] : '';

        if ( is_admin() && 'edit.php' === $pagenow && isset($_GET['post_type']) && 'vraag-en-aanbod' === $_GET['post_type'] && $status ) {
            $query->query_vars['meta_key'] = $meta_key;
            $query->query_vars['meta_value'] = $status;
        }
    }

    function customTableHead($columns) {
        unset($columns['date']);
        $columns['vea_categorie'] = 'Categorie';
        $columns['vea_type'] = 'Type';
        $columns['vea_status'] = 'Status';
        $columns['date'] = 'Date';

        return $columns;
    }

    function customTableContent($col_name, $post_id) {
        $status = get_post_meta( $post_id, '_vraag_en_aanbod_status', true );
        $type = get_post_meta($post_id, '_vraag_en_aanbod_type', true);
        $categorie = get_post_meta($post_id, '_vraag_en_aanbod_categorie', true);

        if ( $col_name == 'vea_categorie') {
            echo '<p style="text-transform:capitalize;">' . $categorie . '</p>';
        }

        if( $col_name == 'vea_type') {
            echo '<p style="text-transform:capitalize;">' . $type  . '</p>';
        }

        if( $col_name == 'vea_status') {
            if ( $status == 'open' ) {
                echo '<p style="text-transform:capitalize;font-weight:800;">' . $status  . '</p>';
            } else if ( $status == 'match' ) {
                echo '<p style="text-transform:capitalize;font-weight:800;color:green;">' . $status  . '</p>';
            } else {
                echo '<p style="text-transform:capitalize;font-weight:800;color:red;">' . $status  . '</p>';
            }
        }

    }

    function customSortableColumns($columns) {
        $columns['vea_type'] = '_vraag_en_aanbod_type';
        $columns['vea_status'] = '_vraag_en_aanbod_status';
        return $columns;
    }

    function veaOrderby( $query ) {
        if (! is_admin() || ! $query->is_main_query() ) {
            return;
        }

        if ( '_vraag_en_aanbod_type' === $query->get('orderby') ) {
            $query->set('orderby', 'meta_value');
            $query->set('meta_key', '_vraag_en_aanbod_type');
        }

        if ( '_vraag_en_aanbod_status' === $query->get('orderby') ) {
            $query->set('orderby', 'meta_value');
            $query->set('meta_key', '_vraag_en_aanbod_status');
        }
    }

}