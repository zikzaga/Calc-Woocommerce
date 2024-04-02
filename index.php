<?php
/*
 * Plugin Name:       Calc by Tigran
 * Plugin URI:        https://tjiv.ru
 * Description:       Easily create Online calculators
 * Author:            Tigran
 * Author URI:        https://tjiv.ru
 * Version:           0.0.1
 * Text Domain:       calculator-builder
 * Domain Path:       languages
 * Requires PHP:      7.4
*/
function clacl_enqueue_styles() {
    wp_enqueue_style( 'calc-style', plugin_dir_url( __FILE__ ) . 'style.css' );
}
add_action( 'wp_enqueue_scripts', 'clacl_enqueue_styles' );

function calculator_shortcode( $atts ) {

	$atts = shortcode_atts( array(
        'b' => 5.37, 
        'hide_b' => false 
    ), $atts );

    ob_start(); ?>
<form class="calculator-form">
    <label for="x">Рассчитать время работы</label>
    <input type="text" id="x" name="x" style="width: 70%;" placeholder="Месячный расход кВт"/>
    <div id="hidden" style="display: none;"> 
        <label for="b">Введите значение b:</label>
        <input type="text"  id="b" name="b" value="<?php echo esc_attr( $atts['b'] ); ?>" />
    </div>
    <button type="submit" style="width: 70%;" >Рассчитать</button>
        <div id="calculator-results">
            <span id="y-value" style="display: none;"></span>
            <span id="c-value" class="c-result"></span>
        </div>
</form>
   <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.calculator-form').addEventListener('submit', function(e) {
                e.preventDefault();
                var x = parseFloat(document.getElementById('x').value);
                var b = parseFloat(document.getElementById('b').value);
                var y = (x / 30) / 24;
                var c = b / y;
                document.getElementById('y-value').innerHTML = "Y: " + y.toFixed(2);
                document.getElementById('c-value').innerHTML = "Время работы: " + c.toFixed(2);
                document.getElementById('y-value').classList.remove('hidden'); // Показываем значение Y
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('calculator', 'calculator_shortcode');