<?php
/**
 * File for Largo's Term Sidebars
 *
 * @package Largo
 */

/**
 * Display the fields for selecting icons for terms in the "post-type" taxonomy
 */
class Largo_Term_Sidebars {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'edit_category_form_fields', array( $this, 'display_fields' ) );
		add_action( 'edit_tag_form_fields', array( $this, 'display_fields' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'edit_terms', array( $this, 'edit_terms' ), 10, 2 );
		add_action( 'create_term', array( $this, 'edit_terms' ), 10, 2 );
	}

	/**
	 * Return a list of taxonomies that term sidebars are enabled for
	 *
	 * @filter largo_get_sidebar_taxonomies
	 * @return Array of taxonomy slugs
	 */
	public function get_sidebar_taxonomies() {
		if ( empty( $this->_sidebar_taxonomies ) ) {
			$this->_sidebar_taxonomies = apply_filters( 'largo_get_sidebar_taxonomies', array( 'category', 'post_tag', 'series' ) );
		}
		return $this->_sidebar_taxonomies;
	}

	/**
	 * Renders the form fields on the term's edit page
	 *
	 * @param WP_Term $term The term for which the fields should be displayed.
	 * @return nothing
	 */
	public function display_fields( $term ) {
		if ( ! in_array( $term->taxonomy, $this->get_sidebar_taxonomies(), true ) ) {
			// abort if the term doesn't belong to the taxonomies to have icons.
			return;
		}

		// get the proxy post id.
		$post_id = largo_get_term_meta_post( $term->taxonomy, $term->term_id );
		$current_value = largo_get_term_meta( $term->taxonomy, $term->term_id, 'custom_sidebar', true );
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="custom_sidebar"><?php esc_html_e( 'Archive Sidebar', 'largo' ); ?></label></th>
			<td>
				<select name="custom_sidebar" id="custom_sidebar" style="min-width: 300px;">
					<?php largo_custom_sidebars_dropdown( $current_value, false, $post_id ); // get a list of sidebar options. ?>
				</select>
				<br/>
				<p class="description"><?php esc_html_e( 'The sidebar to display on this term\'s archive page.', 'largo' ); ?></p>
				<?php
					wp_nonce_field( 'custom_sidebar-' . $term->term_id, '_custom_sidebar_nonce' );
				?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Renders the form fields for the new form creation on the term listing paga
	 *
	 * @param string $taxonomy unused.
	 */
	public function display_add_new_field( $taxonomy ) {
		?>
		<div class="form-field">
			<label for="custom_sidebar"><?php esc_html_e( 'Archive Sidebar', 'largo' ); ?></label>
			<select name="custom_sidebar" id="custom_sidebar" style="min-width: 300px;">
				<?php largo_custom_sidebars_dropdown( '', false, 0 ); // get the options. ?>
			</select>
			<p class="description"><?php esc_html_e( 'The sidebar to show on this term\'s archive.', 'largo' ); ?></p>
			<?php wp_nonce_field( 'custom_sidebar-new', '_custom_sidebar_nonce' ); ?>
		</div>
		<?php
	}

	/**
	 * Attach the Javascript and Stylesheets to the term edit page
	 *
	 * @param string $hook_suffix what page we're running this on.
	 */
	public function admin_enqueue_scripts( $hook_suffix ) {
		// @todo: does this need nonce verification?
		if ( ! isset( $_REQUEST['taxonomy'] ) ) {
			return;
		}

		$taxonomy = wp_unslash( $_REQUEST['taxonomy'] );

		if ( 'edit-tags.php' === $hook_suffix && ! empty( $taxonomy ) ) {
			if ( ! in_array( $taxonomy, $this->get_sidebar_taxonomies(), true ) ) {
				// abort if the term doesn't belong to the taxonomies to have icons.
				return;
			}

			add_action( $taxonomy . '_add_form_fields', array( $this, 'display_add_new_field' ) );
		}
	}

	/**
	 * Save the results from the term edit page
	 *
	 * @filter edit_terms
	 * @param int|string $term_id  the term ID.
	 * @param string     $taxonomy the taxonomy of the term.
	 */
	public function edit_terms( $term_id, $taxonomy ) {
		// nonce verification comes later in this function.
		if ( isset( $_POST['action'] ) && 'add-tag' === $_POST['action'] ) {
			$nonce_action = 'custom_sidebar-new';
		} else {
			$nonce_action = 'custom_sidebar-' . $term_id;
		}

		if ( isset( $_POST['_custom_sidebar_nonce'] ) && wp_verify_nonce( wp_unslash( $_POST['_custom_sidebar_nonce'] ), $nonce_action ) ) {
			// @todo: better verification/sanitization of this
			$sidebar = wp_unslash( $_POST['custom_sidebar'] );

			// @todo: make sure that the taxonomy is one that is valid for getting sidebars

			largo_update_term_meta( $taxonomy, $term_id, 'custom_sidebar', $sidebar );
		}
	}
}

$largo['term-sidebars'] = new Largo_Term_Sidebars();
