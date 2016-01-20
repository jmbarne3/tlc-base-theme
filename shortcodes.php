<?php
/**
 * Base Shortcode class
 **/
abstract class Shortcode {
    public
        $name        = 'Shortcode', // The name of the shortcode.
        $command     = 'shortcode', // The command used to call the shortcode.
        $description = 'This is the description of the shortcode.', // The description of the shortcode.
        $params      = array(), // The parameters used by the shortcode.
        $callback    = 'callback',
        $wysiwyg     = True; // Whether to add it to the shortcode Wysiwyg modal.
    
    /*
     * Register the shortcode.
     * @since v0.0.1
     * @author Jim Barnes
     * @return void
     */
    public function register_shortcode() {
        add_shortcode( $this->command, array( $this, $this->callback ) );
    }
    
    /*
     * Returns the html option markup.
     * @since v0.0.1
     * @author Jim Barnes
     * @return string
     */
    public function get_option_markup() {
        return sprintf('<option value="%s">%s</option>', $this->command, $this->name);
    }
    
    /*
     * Returns the description html markup.
     * @since v0.0.1
     * @author Jim Barnes
     * @return string
     */
    public function get_description_markup() {
        return sprintf('<li class="shortcode-%s">%s</li>', $this->command, $this->description);
    }
    
    /*
     * Returns the form html markup.
     * @since v0.0.1
     * @author Jim Barnes
     * @return string
     */
    public function get_form_markup() {
        ob_start();
?>
        <li class="shortcode-<?php echo $this->command; ?>">
            <h3><?php echo $this->name; ?> Options</h3>
<?php
        foreach($this->params as $param) :
?>
            <h4><?php echo $param->name; ?></h4>
            <p class="help"><?php echo $param->help_text; ?></p>
            <?php echo $this->get_field_input( $param, $this->command ); ?>
<?php
        endforeach;
?>
        </li>
<?php
        return ob_get_clean();
    }
    
    /*
     * Returns the appropriate markup for the field.
     * @since v0.0.1
     * @author Jim Barnes
     * return string
     */
    private function get_field_input( $field, $command ) {
        $name      = isset( $field['name'] ) ? $field['name'] : '';
        $id        = isset( $field['id'] ) ? $field['id'] : '';
        $help_text = isset( $field['help_text'] ) ? $field['help_text'] : '';
        $type      = isset( $field['type'] ) ? $field['type'] : 'text';
        $default   = isset( $field['default'] ) ? $field['default'] : '';
        $template  = isset( $field['template'] ) ? $tempalte['template'] : '';
        
        $retval = '<h4>' . $name . '</h4>';
        if ( $help_text ) {
            $retval .= '<p class="help">' . $help_text . '</p>';
        } 

        switch( $type ) {
            case 'text':
            case 'date':
            case 'email':
            case 'url':
            case 'number':
            case 'color':
                $retval .= '<input type="' . $type . '" name="' . $command . '-' . $id . '" value="" default-value="' . $default . '" data-parameter="' . $id . '">';
                break;
            case 'dropdown':
                $choices = is_array( $field['choices'] ) ? $field['choices'] : array();
                $retval .= '<select type="text" name="' . $command . '-' . $id . '" value="" default-value="' . $default . '" data-parameter="' . $id . '">';
                foreach ( $choices as $choice ) {
                    $retval .= '<option value="' . $choice['value'] . '">' . $choice['name'] . '</option>';
                }
                $retval .= '</select>';
                break;
        }
        
        return $retval;
    }
}

class IconButton extends Shortcode {
    public
        $name        = 'Icon Button', // The name of the shortcode.
        $command     = 'icon_button', // The command used to call the shortcode.
        $description = 'Inserts an icon.', // The description of the shortcode.
        $params      = array(
            array(
                'name'      => 'Icon',
                'id'        => 'icon',
                'help_text' => 'Choose the icon you would like to appear.',
                'type'      => 'text',
                'default'   => 'Learn More'
            ),
            array(
                'name'      => 'Button Color',
                'id'        => 'btn_color',
                'help_text' => 'The color of the button',
                'type'      => 'dropdown',
                'choices'   => array(
                    array( 'name' => 'Info', 'value' => 'btn-info' ),
                    array( 'name' => 'Warning', 'value' => 'btn-warning' ),
                    array( 'name' => 'Danger', 'value' => 'btn-danger' ),
                    array( 'name' => 'Success', 'value' => 'btn-success' )
                ),
                'default'   => 'Info'
            ),
            array(
                'name'      => 'Button Text',
                'id'        => 'btn_text',
                'help_text' => 'The text of the button',
                'type'      => 'text'
            ),
            array(
                'name'      => 'URL',
                'id'        => 'url',
                'help_text' => 'The URL of the icon button',
                'type'      => 'url'
            ),
            array(
                'name'      => 'Text',
                'id'        => 'text',
                'help_text' => 'The text to appear below the icon',
                'type'      => 'text'
            ),
            array(
                'name'      => 'Color',
                'id'        => 'color',
                'help_Text' => 'The color of the icon',
                'type'      => 'color',
                'default'   => '#428bca'
            ),
        ),
        $wysiwyg     = True; // Whether to add it to the shortcode Wysiwyg modal.

    public function callback( $attr, $content='' ) {
        $attr = shortcode_atts( array(
                'btn_color' => 'btn-info',
                'btn_text'  => 'Learn More',
                'text'      => '',
                'color'     => '#428bca',
                'url'       => '#',
                'icon'      => null
            ), $attr
        );

        ob_start();
?>
        <?php if ( $attr['icon'] ) : ?>
            <div class="icon-button">
                <a href="<?php echo $attr['url']; ?>">
                    <i class="fa <?php echo $attr['icon']; ?>" style="color: <?php echo $attr['color']; ?>; border-color: <?php echo $attr['color']; ?>;"></i>
                </a>
                <h3 class="icon-button-title">
                    <a href="<?php echo $attr['url']; ?>">
                        <?php echo $attr['text']; ?>
                    </a>
                </h3>
                <a href="<?php echo $attr['url']; ?>" class="btn btn-lg <?php echo $attr['btn_color']; ?>"><?php echo $attr['btn_text']; ?></a>
            </div>
        <?php endif; ?>
<?php
        return ob_get_clean();
    }
}

?>