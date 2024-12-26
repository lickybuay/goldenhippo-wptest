<?php
define('PLUGIN_DIR', plugin_dir_path(__FILE__) . '../../');
define('OPTION_NAME', 'wp_golden_hippo_form_data');
define('ADMIN_MENU', 'wp-golden-hippo-form');
define('PLUGIN_URL', plugin_dir_url(__FILE__) . '../');

class GHippo_FormPlugin
{
    const OPTIONS = [
        "option1" => "Option 1",
        "option2" => "Option 2"
    ];

    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_style']);
        add_action('wp_ajax_submit_save_hippo_form', array($this, 'handle_custom_endpoint'));
    }

    public function add_admin_menu()
    {
        add_menu_page(
            'Hippo Form Plugin',
            'Hippo Form',
            'manage_options',
            ADMIN_MENU,
            [$this, 'render_admin_page'],
            'dashicons-admin-generic',
            20
        );
    }

    public function enqueue_style($hook)
    {
        if ($hook !== 'toplevel_page_' . ADMIN_MENU) {
            return;
        }

        wp_enqueue_style(
            'bootstrap-css',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
            [],
            null,
            false
        );
        if (is_admin()) {
            wp_enqueue_style(
                'hipoo-editor-style-css',
                PLUGIN_URL . 'styles/editor-styles.css',
                [],
                '1.0',
                'all'
            );
        }
    }

    public function enqueue_scripts($hook)
    {
        if ($hook !== 'toplevel_page_' . ADMIN_MENU) {
            return;
        }
        wp_enqueue_script(
            'bootstrap-js',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
            [],
            null,
            false
        );

        if (is_admin()) {
            wp_enqueue_script('wp-tinymce');
            wp_enqueue_script(
                'admin-js',
                PLUGIN_URL . '/js/admin.js',
                [],
                null,
                false
            );
        }
    }

    public function handle_custom_endpoint()
    {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Unauthorized'], 403);
        }
        if (!isset($_POST['save_hippo_form_nonce']) || !wp_verify_nonce($_POST['save_hippo_form_nonce'], 'save_hippo_form_action')) {
            wp_send_json_error(['message' => 'Invalid nonce'], 403);
        }
        $url_field = $_POST['url_field'] ?? '';
        if (!empty($url_field) && !filter_var($url_field, FILTER_VALIDATE_URL)) {
            wp_send_json_error(['message' => 'Invalid URL provided'], 400);
        }
        if (!isset($_POST['checkbox_field']) || $_POST['checkbox_field'] !== '1') {
            wp_send_json_error(['message' => 'Checkbox must be checked'], 400);
        }
        $data = [
            'text_field' => sanitize_text_field($_POST['text_field'] ?? ''),
            'url_field' => esc_url_raw($_POST['url_field'] ?? ''),
            'checkbox_field' => isset($_POST['checkbox_field']) ? 1 : 0,
            'radio_field' => sanitize_text_field($_POST['radio_field'] ?? ''),
            'dropdown_field' => sanitize_text_field($_POST['dropdown_field'] ?? ''),
            'rich_text_field' => wp_kses_post($_POST['rich_text_field'] ?? ''),
        ];
        update_option(OPTION_NAME, $data);
        wp_send_json_success(['message' => 'Form saved successfully']);
    }

    public function render_admin_page()
    {
        $data = get_option(OPTION_NAME, []);
        include PLUGIN_DIR . 'admin/views/admin-page.php';
    }
}
