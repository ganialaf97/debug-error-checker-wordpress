<?php
/*
Plugin Name: Debug Error Checker
Description: A simple plugin to display debug error messages with search, pagination, and dynamic row limit.
Version: 1.0
Author: alafganidev
*/

function enqueue_debug_error_assets() {
    wp_enqueue_style('debug-error-style', plugin_dir_url(__FILE__) . 'style.css', array(), '1.0');
}
add_action('admin_enqueue_scripts', 'enqueue_debug_error_assets');

function display_debug_errors() {
    $has_error = false;
    $error_data = array();
    foreach (debug_backtrace() as $error) {
        if (isset($error['file']) && isset($error['line'])) {
            $has_error = true;
            $error_data[] = array(
                'type' => 'Error',
                'date' => date('Y-m-d H:i:s'),
                'file' => $error['file'],
                'line' => $error['line']
            );
        }
    }

    echo '<div class="debug-error-container">';
    echo '<h2>Debug Error Messages:</h2>';
    if ($has_error) {
        echo '<table id="debug-error-table" class="display">';
        echo '<thead><tr><th>Tipe Error</th><th>Tanggal Error</th><th>File</th><th>Line</th></tr></thead>';
        echo '<tbody>';
        foreach ($error_data as $error) {
            echo '<tr><td class="debug-error-message">' . esc_html($error['type']) . '</td><td>' . esc_html($error['date']) . '</td><td>' . esc_html($error['file']) . '</td><td>' . esc_html($error['line']) . '</td></tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p class="no-error-message">Your Website Currently Not Error, Good!</p>';
    }
    echo '<div class="author-info">';
    echo '<span class="author-icon dashicons dashicons-admin-users"></span>';
    echo '<a class="author-link" href="https://alafgani.web.id/">Author: alafganidev</a>';
    echo '</div>';
    echo '<div class="author-info">';
    echo '<a class="donate-button" href="https://example.com/donate">Donate</a>';
    echo '<a class="instagram-icon dashicons dashicons-instagram" href="https://www.instagram.com/alafganiwebid/" target="_blank"></a>';
    echo '</div>';
    echo '</div>';
}

function debug_error_checker_menu() {
    add_menu_page(
        'Debug Error Checker',
        'Debug Error Checker',
        'manage_options',
        'debug-error-checker',
        'display_debug_error_page'
    );
}
add_action('admin_menu', 'debug_error_checker_menu');

function display_debug_error_page() {
    echo '<div class="wrap">';
    echo '<h2>Debug Error Checker</h2>';
    echo '<p>View debug error messages here:</p>';
    display_debug_errors();
    echo '</div>';
}
?>
<style>
    .debug-error-container {
        background-color: #f8f8f8;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-top: 20px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        padding: 15px;
    }

    .debug-error-container h2 {
        margin-bottom: 10px;
        font-size: 20px;
    }

    .debug-error-message {
        color: red;
    }

    .no-error-message {
        color: green;
        font-weight: bold;
    }

    .author-info {
        display: flex;
        align-items: center;
        margin-top: 20px;
    }

    .author-icon {
        margin-right: 10px;
        font-size: 20px;
    }

    .author-link {
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }

    .donate-button {
        background-color: #007bff;
        color: #fff;
        padding: 6px 12px;
        border-radius: 5px;
        text-decoration: none;
    }

    .instagram-icon {
        font-size: 20px;
        color: #E1306C;
        margin-right: 10px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var table = document.getElementById('debug-error-table');
        if (table) {
            new DataTable(table, {
                lengthMenu: [10, 25, 50],
                language: {
                    search: '_INPUT_',
                    searchPlaceholder: 'Search...',
                    paginate: {
                        next: '&#8594;',
                        previous: '&#8592;'
                    }
                }
            });
        }
    });
</script>
