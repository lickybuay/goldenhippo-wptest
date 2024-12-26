<div class="wrap">
    <h1>Holden Hippo Form</h1>
    <div id="response-message" class="notice" style="display:none;"></div>

    <form id="hippo-form" action="#" method="post" data-endpoint="<?php echo admin_url('admin-ajax.php'); ?>">

        <?php wp_nonce_field('save_hippo_form_action', 'save_hippo_form_nonce'); ?>
        <input type="hidden" name="action" value="submit_save_hippo_form">

        <div class="mt-3">
            <div class="input-group mb-3">
                <span class="input-group-text" for="text_field">Text Field </span>
                <input type="text" class="form-control" id="text_field" name="text_field" value="<?php echo esc_attr($data['text_field'] ?? ''); ?>">
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="url_field">URL Field </label>
                <input type="url" id="url_field" name="url_field" value="<?php echo esc_attr($data['url_field'] ?? ''); ?>" class="form-control">
                <div class="invalid-feedback" style="display: none;">Please enter a valid URL.</div>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="checkbox_field">CheckBox</label>
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="checkbox" id="checkbox_field" name="checkbox_field" value="1" <?php checked(!empty($data['checkbox_field'])); ?> aria-label="Checkbox for following text input">
                </div>
                <div class="invalid-feedback" style="display: none;">You must agree to this checkbox.</div>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="checkbox_field">Radio</label>
                <div class="input-group-text column-gap-2">
                    <label><input class="form-check-input mt-0" type="radio" name="radio_field" value="option1" <?php checked($data['radio_field'] ?? '', 'option1'); ?>> Option 1</label><br>
                    <label><input class="form-check-input mt-0" type="radio" name="radio_field" value="option2" <?php checked($data['radio_field'] ?? '', 'option2'); ?>> Option 2</label>
                </div>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="dropdown_field">Dropdown</label>
                <div class="dropdown">
                    <input type="hidden" id="dropdown_field" name="dropdown_field" value="<?php echo esc_attr($data['dropdown_field'] ?? ''); ?>">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo isset($data['dropdown_field']) ? self::OPTIONS[$data['dropdown_field']] : 'Select an Option'; ?>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?php if ($data['dropdown_field'] === '') {
                                                        echo 'active';
                                                    } ?>" href="javascript:void(0);" data-value="">Select an Option</a></li>
                        <?php foreach (self::OPTIONS as $key => $value) { ?>
                            <li><a class="dropdown-item <?php if ($data['dropdown_field'] === $key) {
                                                            echo 'active';
                                                        } ?>" href="javascript:void(0);" data-value="<?php echo $key; ?>"><?php echo $value; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="input-group align-items-start mb-3">
                <label class="input-group-text" for="dropdown_field">TinyMCE Editor</label>
                <?php wp_editor(
                    $data['rich_text_field'] ?? '',
                    'rich_text_field',
                    [
                        'textarea_name' => 'rich_text_field',
                    ]
                ); ?>
            </div>
        </div>
        <button type="button" id="submit-hippo-form" class="button button-primary">Save Form</button>
    </form>
</div>