<?php
/**
 * WPForms Lite. Load Lite specific features/functionality.
 *
 * @since 1.2.0
 * @package WPForms
 */
class WPForms_Lite {

	/**
	 * Primary class constructor.
	 *
	 * @since 1.2.x
	 */
	public function __construct() {

		$this->includes();

		add_action( 'wpforms_form_settings_notifications', array( $this, 'form_settings_notifications' ), 8, 1 );
		add_action( 'wpforms_setup_panel_after', array( $this, 'form_templates' ) );
		add_filter( 'wpforms_builder_fields_buttons', array( $this, 'form_fields' ), 20 );
		add_action( 'wpforms_builder_panel_buttons', array( $this, 'form_panels' ), 20 );
		add_action( 'wpforms_builder_enqueues_before', array( $this, 'builder_enqueues' ) );
		add_action( 'wpforms_admin_page', array( $this, 'entries_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'addon_page_enqueues' ) );
		add_action( 'wpforms_admin_page', array( $this, 'addons_page' ) );
		add_action( 'wpforms_providers_panel_sidebar', array( $this, 'builder_provider_sidebar' ), 20 );
	}

	/**
	 * Include files.
	 *
	 * @since 1.0.0
	 */
	private function includes() {

		// Bliss.
	}

	/**
	 * Form notification settings, supports multiple notifications.
	 *
	 * @since 1.2.3
	 * @param object $settings
	 */
	public function form_settings_notifications( $settings ) {

		$cc = wpforms_setting( 'email-carbon-copy', false );

		// Fetch next ID and handle backwards compatibility
		if ( empty( $settings->form_data['settings']['notifications'] ) ) {
			$settings->form_data['settings']['notifications'][1]['email']          = ! empty( $settings->form_data['settings']['notification_email'] ) ? $settings->form_data['settings']['notification_email'] : '{admin_email}';
			$settings->form_data['settings']['notifications'][1]['subject']        = ! empty( $settings->form_data['settings']['notification_subject'] ) ? $settings->form_data['settings']['notification_subject'] : sprintf( __( 'New %s Entry', 'wpforms ' ), $settings->form->post_title );
			$settings->form_data['settings']['notifications'][1]['sender_name']    = ! empty( $settings->form_data['settings']['notification_fromname'] ) ? $settings->form_data['settings']['notification_fromname'] : get_bloginfo( 'name' );
			$settings->form_data['settings']['notifications'][1]['sender_address'] = ! empty( $settings->form_data['settings']['notification_fromaddress'] ) ? $settings->form_data['settings']['notification_fromaddress'] : '{admin_email}';
			$settings->form_data['settings']['notifications'][1]['replyto']        = ! empty( $settings->form_data['settings']['notification_replyto'] ) ? $settings->form_data['settings']['notification_replyto'] : '';
		}
		$id = 1;

		echo '<div class="wpforms-panel-content-section-title">';
			_e( 'Notifications', 'wpforms' );
		echo '</div>';

		echo '<p class="wpforms-alert wpforms-alert-info">Want multiple notifications with smart conditional logic?<br><a href="' . wpforms_admin_upgrade_link() . '" class="wpforms-upgrade-modal" target="_blank" rel="noopener"><strong>Upgrade to PRO</strong></a> to unlock it and more awesome features.</p>';

		wpforms_panel_field(
			'select',
			'settings',
			'notification_enable',
			$settings->form_data,
			__( 'Notifications', 'wpforms' ),
			array(
				'default' => '1',
				'options' => array(
					'1' => __( 'On', 'wpforms' ),
					'0' => __( 'Off', 'wpforms' ),
				),
			)
		);

		echo '<div class="wpforms-notification">';

			echo '<div class="wpforms-notification-header">';
				echo '<span>' . __( 'Default Notification', 'wpforms' ) . '</span>';
			echo '</div>';

			wpforms_panel_field(
				'text',
				'notifications',
				'email',
				$settings->form_data,
				__( 'Send To Email Address', 'wpforms' ),
				array(
					'default'    => '{admin_email}',
					'tooltip'    => __( 'Enter the email address to receive form entry notifications. For multiple notifications, separate email addresses with a comma.', 'wpforms' ),
					'smarttags'  => array(
						'type'   => 'fields',
						'fields' => 'email',
					),
					'parent'     => 'settings',
					'subsection' => $id,
					'class'      => 'email-recipient',
				)
			);
			if ( $cc ) :
			wpforms_panel_field(
				'text',
				'notifications',
				'carboncopy',
				$settings->form_data,
				__( 'CC', 'wpforms' ),
				array(
					'smarttags'  => array(
						'type'   => 'fields',
						'fields' => 'email',
					),
					'parent'     => 'settings',
					'subsection' => $id,
				)
			);
			endif;
			wpforms_panel_field(
				'text',
				'notifications',
				'subject',
				$settings->form_data,
				__( 'Email Subject', 'wpforms' ),
				array(
					'default'    => sprintf( _x( 'New Entry: %s', 'Form name', 'wpforms' ), $settings->form->post_title ),
					'smarttags'  => array(
						'type' => 'all',
					),
					'parent'     => 'settings',
					'subsection' => $id,
				)
			);
			wpforms_panel_field(
				'text',
				'notifications',
				'sender_name',
				$settings->form_data,
				__( 'From Name', 'wpforms' ),
				array(
					'default'    => sanitize_text_field( get_option( 'blogname' ) ),
					'smarttags'  => array(
						'type'   => 'fields',
						'fields' => 'name,text',
					),
					'parent'     => 'settings',
					'subsection' => $id,
				)
			);
			wpforms_panel_field(
				'text',
				'notifications',
				'sender_address',
				$settings->form_data,
				__( 'From Email', 'wpforms' ),
				array(
					'default'    => '{admin_email}',
					'smarttags'  => array(
						'type'   => 'fields',
						'fields' => 'email',
					),
					'parent'     => 'settings',
					'subsection' => $id,
				)
			);
			wpforms_panel_field(
				'text',
				'notifications',
				'replyto',
				$settings->form_data,
				__( 'Reply-To', 'wpforms' ),
				array(
					'smarttags'  => array(
						'type'   => 'fields',
						'fields' => 'email',
					),
					'parent'     => 'settings',
					'subsection' => $id,
				)
			);
			wpforms_panel_field(
				'textarea',
				'notifications',
				'message',
				$settings->form_data,
				__( 'Message', 'wpforms' ),
				array(
					'rows'       => 6,
					'default'    => '{all_fields}',
					'smarttags'  => array(
						'type' => 'all',
					),
					'parent'     => 'settings',
					'subsection' => $id,
					'class'      => 'email-msg',
					'after'      => '<p class="note">' . __( 'To display all form fields, use the <code>{all_fields}</code> Smart Tag.', 'wpforms' ) . '</p>',
				)
			);

		echo '</div>';
	}

	/**
	 * Display/register additional templates available in the Pro version.
	 *
	 * @since 1.0.6
	 */
	public function form_templates() {

		$templates = array(
			array(
				'name'        => __( 'Request A Quote Form', 'wpforms' ),
				'slug'        => 'request-quote',
				'description' => __( 'Start collecting leads with this pre-made Request a quote form. You can add and remove fields as needed.', 'wpforms' ),
			),
			array(
				'name'        => __( 'Donation Form', 'wpforms' ),
				'slug'        => 'donation',
				'description' => __( 'Start collecting donation payments on your website with this ready-made Donation form. You can add and remove fields as needed.', 'wpforms' ),
			),
			array(
				'name'        => __( 'Billing / Order Form', 'wpforms' ),
				'slug'        => 'order',
				'description' => __( 'Collect payments for product and service orders with this ready-made form template. You can add and remove fields as needed.', 'wpforms' ),
			),
		);
		?>
		<div class="wpforms-setup-title">
			<?php _e( 'Unlock Pre-Made Form Templates', 'wpforms' ); ?> <a href="<?php echo wpforms_admin_upgrade_link(); ?>" target="_blank" rel="noopener" class="btn-green wpforms-upgrade-link wpforms-upgrade-modal" style="text-transform: uppercase;font-size: 13px;font-weight: 700;padding: 5px 10px;vertical-align: text-bottom;"><?php _e( 'Upgrade', 'wpforms' ); ?></a>
		</div>
		<p class="wpforms-setup-desc">
			<?php _e( 'While WPForms Lite allows you to create any type of form, you can speed up the process by unlocking our other pre-built form templates among other features, so you never have to start from scratch again...', 'wpforms' ); ?>
		</p>
		<div class="wpforms-setup-templates wpforms-clear" style="opacity:0.5;">
			<?php
			$x = 0;
			foreach ( $templates as $template ) {
				$class = 0 === $x % 3 ? 'first ' : '';
				?>
				<div class="wpforms-template upgrade-modal <?php echo $class; ?>" id="wpforms-template-<?php echo sanitize_html_class( $template['slug'] ); ?>">
					<div class="wpforms-template-name wpforms-clear">
						<?php echo esc_html( $template['name'] ); ?>
					</div>
					<div class="wpforms-template-details">
						<p class="desc"><?php echo esc_html( $template['description'] ); ?></p>
					</div>
				</div>
				<?php
				$x++;
			}
			?>
		</div>
		<?php
	}

	/**
	 * Display/register additional fields available in the Pro version.
	 *
	 * @since 1.0.0
	 * @param array $fields
	 * @return array
	 */
	public function form_fields( $fields ) {

		$fields['fancy']['fields'] = array(
			array(
				'icon'  => 'fa-link',
				'name'  => 'Website / URL',
				'type'  => 'url',
				'order' => '1',
				'class' => 'upgrade-modal',
			),
			array(
				'icon'  => 'fa-map-marker',
				'name'  => 'Address',
				'type'  => 'address',
				'order' => '2',
				'class' => 'upgrade-modal',
			),
			array(
				'icon'  => 'fa-phone',
				'name'  => 'Phone',
				'type'  => 'phone',
				'order' => '3',
				'class' => 'upgrade-modal',
			),
			array(
				'icon'  => 'fa-lock',
				'name'  => 'Password',
				'type'  => 'password',
				'order' => '4',
				'class' => 'upgrade-modal',
			),
			array(
				'icon'  => 'fa-calendar-o',
				'name'  => 'Date / Time',
				'type'  => 'date-time',
				'order' => '5',
				'class' => 'upgrade-modal',
			),
			array(
				'icon'  => 'fa-eye-slash',
				'name'  => 'Hidden Field',
				'type'  => 'hidden',
				'order' => '6',
				'class' => 'upgrade-modal',
			),
			array(
				'icon'  => 'fa-upload',
				'name'  => 'File Upload',
				'type'  => 'file-upload',
				'order' => '7',
				'class' => 'upgrade-modal',
			),
			array(
				'icon'  => 'fa-code',
				'name'  => 'HTML',
				'type'  => 'html',
				'order' => '8',
				'class' => 'upgrade-modal',
			),
			array(
				'icon'  => 'fa-files-o',
				'name'  => 'Page Break',
				'type'  => 'pagebreak',
				'order' => '9',
				'class' => 'upgrade-modal',
			),
			array(
				'icon'  => 'fa-arrows-h',
				'name'  => 'Divider',
				'type'  => 'Divider',
				'order' => '10',
				'class' => 'upgrade-modal',
			),
		);

		$fields['payment']['fields'] = array(
			array(
				'icon'  => 'fa-file-o',
				'name'  => 'Single Item',
				'type'  => 'payment-single',
				'order' => '1',
				'class' => 'upgrade-modal',
			),
			array(
				'icon'  => 'fa-list-ul',
				'name'  => 'Multiple Items',
				'type'  => 'payment-multiple',
				'order' => '2',
				'class' => 'upgrade-modal',
			),
			array(
				'icon'  => 'fa-caret-square-o-down',
				'name'  => 'Dropdown Items',
				'type'  => 'payment-multiple',
				'order' => '3',
				'class' => 'upgrade-modal',
			),
			array(
				'icon'  => 'fa-money',
				'name'  => 'Total',
				'type'  => 'payment-total',
				'order' => '4',
				'class' => 'upgrade-modal',
			),
		);

		return $fields;
	}

	/**
	 * Display/register additional panels available in the Pro version.
	 *
	 * @since 1.0.0
	 */
	public function form_panels() {

		?>
		<button class="wpforms-panel-payments-button upgrade-modal" data-panel="payments">
			<i class="fa fa-usd"></i><span><?php _e( 'Payments', 'wpforms' ); ?></span>
		</button>
		<?php
	}

	/**
	 * Load assets for lite version with the admin builder.
	 *
	 * @since 1.0.0
	 */
	public function builder_enqueues() {

		wp_enqueue_script(
			'wpforms-builder-lite',
			WPFORMS_PLUGIN_URL . 'lite/assets/js/admin-builder-lite.js',
			array( 'jquery', 'jquery-confirm' ),
			WPFORMS_VERSION,
			false
		);

		wp_localize_script(
			'wpforms-builder-lite',
			'wpforms_builder_lite',
			array(
				'upgrade_title'   => __( 'is a PRO Feature', 'wpforms' ),
				'upgrade_message' => __( 'We\'re sorry, %name% is not available on your plan.<br><br>Please upgrade to the PRO plan to unlock all these awesome features.', 'wpforms' ),
				'upgrade_button'  => __( 'Upgrade to PRO', 'wpforms' ),
				'upgrade_url'     => wpforms_admin_upgrade_link(),
				/* translators: %1$s - opening link tag; %2$s - closing link tag; %3$s - opening link tag; %4$s - closing link tag. */
				'upgrade_modal'   => sprintf(
										wp_kses(
											__( '<p>Thanks for your interest in WPForms Pro!<br>If you have any questions or issues just %1$slet us know%2$s.</p><p>After purchasing WPForms Pro, you\'ll need to <strong>download and install the Pro version of the plugin</strong>, and then <strong>remove the free plugin</strong>.<br>(Don\'t worry, all your forms and settings will be preserved.)</p><p>Check out %3$sour documentation%4$s for step-by-step instructions.</p>', 'wpforms' ),
											array(
												'br'     => array(),
												'strong' => array(),
												'p'      => array(),
												'a'      => array( 'href', 'rel', 'target' ),
											)
										),
										'<a href="https://wpforms.com/contact/" target="_blank" rel="noopener noreferrer">',
										'</a>',
										'<a href="https://wpforms.com/docs/upgrade-wpforms-lite-paid-license/" target="_blank" rel="noopener noreferrer">',
										'</a>'
									),
			)
		);
	}

	/**
	 * Display other providers available with paid license.
	 *
	 * @since 1.3.8
	 */
	public function builder_provider_sidebar() {

		$providers = array(
			array(
				'name' => 'AWeber',
				'slug' => 'aweber',
				'img'  => 'addon-icon-aweber.png',
			),
			array(
				'name' => 'Campaign Monitor',
				'slug' => 'campaign-monitor',
				'img'  => 'addon-icon-campaign-monitor.png',
			),
			array(
				'name' => 'GetResponse',
				'slug' => 'getresponse',
				'img'  => 'addon-icon-getresponse.png',
			),
			array(
				'name' => 'MailChimp',
				'slug' => 'mailchimp',
				'img'  => 'addon-icon-mailchimp.png',
			),
			array(
				'name' => 'Zapier',
				'slug' => 'zapier',
				'img'  => 'addon-icon-zapier.png',
			),
		);

		foreach ( $providers as $provider ) {
			echo '<a href="#" class="wpforms-panel-sidebar-section icon wpforms-panel-sidebar-section-' . esc_attr( $provider['slug'] ) . ' upgrade-modal" data-name="' . esc_attr( $provider['name'] ) . '">';
				echo '<img src="' . WPFORMS_PLUGIN_URL . 'lite/assets/images/' . $provider['img'] . '">';
				echo esc_html( $provider['name'] );
				echo '<i class="fa fa-angle-right wpforms-toggle-arrow"></i>';
			echo '</a>';
		}
	}


	/**
	 * Notify user that entries is a pro feature.
	 *
	 * @since 1.0.0
	 */
	public function entries_page() {

		if ( ! isset( $_GET['page'] ) || 'wpforms-entries' !== $_GET['page'] ) {
			return;
		}
		?>
		<style type="text/css">
			.wpforms-admin-content {
				-webkit-filter: blur(3px);
				-moz-filter: blur(3px);
				-ms-filter: blur(3px);
				-o-filter: blur(3px);
				filter: blur(3px);
			}
			.wpforms-admin-content a {
				pointer-events: none;
				cursor: default;
			}
			.ie-detected {
				position: absolute;
				top:0;
				width: 100%;
				height: 100%;
				left: 0;
				background-color: #f1f1f1;
				opacity: 0.65;
				z-index: 10;
			}
			.wpforms-admin-content,
			.wpforms-admin-content-wrap {
				position: relative;
			}
			.entries-modal {
				text-align: center;
				width: 730px;
				box-shadow: 0 0 60px 30px rgba(0,0,0,0.15);
				border-radius: 3px;
				position: absolute;
				top: 75px;
				left: 50%;
				margin: 0 auto 0 -365px;
				z-index: 100;
			}
			.entries-modal *,
			.entries-modal *::before,
			.entries-modal *::after {
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			.entries-modal h2 {
				font-size: 20px;
				margin: 0 0 16px 0;
				padding: 0;
			}
			.entries-modal p {
				font-size: 16px;
				color: #666;
				margin: 0 0 30px 0;
				padding: 0;
			}
			.entries-modal-content {
				background-color: #fff;
				border-radius: 3px 3px 0 0;
				padding: 40px;
			}
			.entries-modal ul {
				float: left;
				width: 50%;
				margin: 0;
				padding: 0 0 0 30px;
				text-align: left;
			}
			.entries-modal li {
				color: #666;
				font-size: 16px;
				padding: 6px 0;
			}
			.entries-modal li .fa {
				color: #2a9b39;
				margin: 0 8px 0 0;
			}
			.entries-modal-button {
				border-radius: 0 0 3px 3px;
				padding: 30px;
				background: #f5f5f5;
				text-align: center;
			}
		</style>
		<script type="text/javascript">
			jQuery(function($){
				var userAgent    = window.navigator.userAgent,
					onlyIEorEdge = /msie\s|trident\/|edge\//i.test(userAgent) && !!( document.uniqueID || window.MSInputMethodContext),
					checkVersion = (onlyIEorEdge && +(/(edge\/|rv:|msie\s)([\d.]+)/i.exec(userAgent)[2])) || NaN;
				if ( !isNaN(checkVersion) ) {
					$('#ie-wrap').addClass('ie-detected');
				}
			})
		</script>
		<div id="wpforms-entries-list" class="wrap wpforms-admin-wrap">
			<h1 class="page-title">Entries</h1>
			<div class="wpforms-admin-content-wrap">
				<div class="entries-modal">
					<div class="entries-modal-content">
						<h2>View and Manage All Your Form Entries inside WordPress</h2>
						<p>Once you upgrade to WPForms Pro, all future form entries will be stored in your WordPress database and displayed on this Entries screen.</p>
						<div class="wpforms-clear">
							<ul class="left">
								<li><i class="fa fa-check" aria-hidden="true"></i> View Entries in Dashboard</li>
								<li><i class="fa fa-check" aria-hidden="true"></i> Export Entries in a CSV File</li>
								<li><i class="fa fa-check" aria-hidden="true"></i> Add Notes / Comments</li>
								<li><i class="fa fa-check" aria-hidden="true"></i> Save Favorite Entries</li>
							</ul>
							<ul class="right">
								<li><i class="fa fa-check" aria-hidden="true"></i> Mark Read / Unread</li>
								<li><i class="fa fa-check" aria-hidden="true"></i> Print Entries</li>
								<li><i class="fa fa-check" aria-hidden="true"></i> Resend Notifications</li>
								<li><i class="fa fa-check" aria-hidden="true"></i> See Geolocation Data</li>
							</ul>
						</div>
					</div>
					<div class="entries-modal-button">
						<a href="<?php echo wpforms_admin_upgrade_link(); ?>" target="_blank" rel="noopener noreferrer" class="wpforms-btn wpforms-btn-lg wpforms-btn-orange wpforms-upgrade-modal">Upgrade to WPForms Pro Now</a>
					</div>
				</div>
			<div class="wpforms-admin-content">
				<div id="ie-wrap"></div>
				<div class="form-details wpforms-clear">
					<span class="form-details-sub">Select Form</span>
					<h3 class="form-details-title">
						Contact Us
						<div class="form-selector">
							<a href="#" title="Open form selector" class="toggle dashicons dashicons-arrow-down-alt2"></a>
							<div class="form-list" style="display: none;">
								<ul><li></li></ul>
							</div>
						</div>
					</h3>
					<div class="form-details-actions">
						<a href="#" class="form-details-actions-edit"><span class="dashicons dashicons-edit"></span> Edit This Form</a>
						<a href="#" class="form-details-actions-preview" target="_blank" rel="noopener"><span class="dashicons dashicons-visibility"></span> Preview Form</a>
						<a href="#" class="form-details-actions-export"><span class="dashicons dashicons-migrate"></span> Download Export (CSV)</a>
						<a href="#" class="form-details-actions-read"><span class="dashicons dashicons-marker"></span> Mark All Read</a>
					</div>
				</div>
				<form id="wpforms-entries-table">
					<ul class="subsubsub">
						<li class="all"><a href="#" class="current">All&nbsp;<span class="count">(<span class="total-num">10</span>)</span></a> |</li>
						<li class="unread"><a href="#">Unread&nbsp;<span class="count">(<span class="unread-num">10</span>)</span></a> |</li>
						<li class="starred"><a href="#">Starred&nbsp;<span class="count">(<span class="starred-num">0</span>)</span></a></li>
					</ul>
					<div class="tablenav top">
						<div class="alignleft actions bulkactions">
							<label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
							<select name="action" id="bulk-action-selector-top">
								<option value="-1">Bulk Actions</option>
							</select>
							<input type="submit" id="doaction" class="button action" value="Apply">
						</div>
						<div class="tablenav-pages one-page">
							<span class="displaying-num">10 items</span>
							<span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">??</span>
							<span class="tablenav-pages-navspan" aria-hidden="true">???</span>
							<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Current Page</label><input class="current-page" id="current-page-selector" type="text" name="paged" value="1" size="1" aria-describedby="table-paging"><span class="tablenav-paging-text"> of <span class="total-pages">1</span></span>
							</span>
							<span class="tablenav-pages-navspan" aria-hidden="true">???</span>
							<span class="tablenav-pages-navspan" aria-hidden="true">??</span></span>
						</div>
						<br class="clear">
					</div>
					<table class="wp-list-table widefat fixed striped entries">
					<thead>
						<tr>
							<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
							<th scope="col" id="indicators" class="manage-column column-indicators column-primary"></th>
							<th scope="col" id="wpforms_field_0" class="manage-column column-wpforms_field_0">Name</th>
							<th scope="col" id="wpforms_field_1" class="manage-column column-wpforms_field_1">Email</th>
							<th scope="col" id="wpforms_field_2" class="manage-column column-wpforms_field_2">Comment or Message</th>
							<th scope="col" id="date" class="manage-column column-date sortable desc"><a href="#"><span>Date</span><span class="sorting-indicator"></span></a></th>
							<th scope="col" id="actions" class="manage-column column-actions">Actions</th>
						</tr>
					</thead>
					<tbody id="the-list" data-wp-lists="list:entry">
						<tr>
							<th scope="row" class="check-column"><input type="checkbox" name="entry_id[]" value="1088"></th>
							<td class="indicators column-indicators has-row-actions column-primary" data-colname=""><a href="#" class="indicator-star star" data-id="1088" title="Star entry"><span class="dashicons dashicons-star-filled"></span></a><a href="#" class="indicator-read read" data-id="1088" title="Mark entry read"><span class="dashicons dashicons-marker"></span></a>
								<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
							</td>
							<td class="wpforms_field_0 column-wpforms_field_0" data-colname="Name">David Wells</td>
							<td class="wpforms_field_1 column-wpforms_field_1" data-colname="Email">DavidMWells@example.com</td>
							<td class="wpforms_field_2 column-wpforms_field_2" data-colname="Comment or Message">Vivamus sit amet dolor arcu. Praesent fermentum semper justo, nec scelerisq???</td>
							<td class="date column-date" data-colname="Date">July 27, 2017</td>
							<td class="actions column-actions" data-colname="Actions"><a href="#" title="View Form Entry" class="view">View</a> <span class="sep">|</span> <a href="#" title="Delete Form Entry" class="delete">Delete</a></td>
						</tr>
						<tr>
							<th scope="row" class="check-column"><input type="checkbox" name="entry_id[]" value="1087"></th>
							<td class="indicators column-indicators has-row-actions column-primary" data-colname=""><a href="#" class="indicator-star star" data-id="1087" title="Star entry"><span class="dashicons dashicons-star-filled"></span></a><a href="#" class="indicator-read read" data-id="1087" title="Mark entry read"><span class="dashicons dashicons-marker"></span></a>
								<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
							</td>
							<td class="wpforms_field_0 column-wpforms_field_0" data-colname="Name">Jennifer Selzer</td>
							<td class="wpforms_field_1 column-wpforms_field_1" data-colname="Email">JenniferLSelzer@example.com</td>
							<td class="wpforms_field_2 column-wpforms_field_2" data-colname="Comment or Message">Maecenas sollicitudin felis et justo elementum, et lobortis justo vulputate???</td>
							<td class="date column-date" data-colname="Date">July 27, 2017</td>
							<td class="actions column-actions" data-colname="Actions"><a href="#" title="View Form Entry" class="view">View</a> <span class="sep">|</span> <a href="#" title="Delete Form Entry" class="delete">Delete</a></td>
						</tr>
						<tr>
							<th scope="row" class="check-column"><input type="checkbox" name="entry_id[]" value="1086"></th>
							<td class="indicators column-indicators has-row-actions column-primary" data-colname=""><a href="#" class="indicator-star star" data-id="1086" title="Star entry"><span class="dashicons dashicons-star-filled"></span></a><a href="#" class="indicator-read read" data-id="1086" title="Mark entry read"><span class="dashicons dashicons-marker"></span></a>
								<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
							</td>
							<td class="wpforms_field_0 column-wpforms_field_0" data-colname="Name">Philip Norton</td>
							<td class="wpforms_field_1 column-wpforms_field_1" data-colname="Email">PhilipTNorton@example.com</td>
							<td class="wpforms_field_2 column-wpforms_field_2" data-colname="Comment or Message">Etiam cursus orci tellus, ut vehicula odio mattis sit amet. Curabitur eros ???</td>
							<td class="date column-date" data-colname="Date">July 27, 2017</td>
							<td class="actions column-actions" data-colname="Actions"><a href="#" title="View Form Entry" class="view">View</a> <span class="sep">|</span> <a href="#" title="Delete Form Entry" class="delete">Delete</a></td>
						</tr>
						<tr>
							<th scope="row" class="check-column"><input type="checkbox" name="entry_id[]" value="1085"></th>
							<td class="indicators column-indicators has-row-actions column-primary" data-colname=""><a href="#" class="indicator-star star" data-id="1085" title="Star entry"><span class="dashicons dashicons-star-filled"></span></a><a href="#" class="indicator-read read" data-id="1085" title="Mark entry read"><span class="dashicons dashicons-marker"></span></a>
								<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
							</td>
							<td class="wpforms_field_0 column-wpforms_field_0" data-colname="Name">Kevin Gregory</td>
							<td class="wpforms_field_1 column-wpforms_field_1" data-colname="Email">KevinJGregory@example.com</td>
							<td class="wpforms_field_2 column-wpforms_field_2" data-colname="Comment or Message">Cras vel orci congue, tincidunt eros vitae, consectetur risus. Proin enim m???</td>
							<td class="date column-date" data-colname="Date">July 27, 2017</td>
							<td class="actions column-actions" data-colname="Actions"><a href="#" title="View Form Entry" class="view">View</a> <span class="sep">|</span> <a href="#" title="Delete Form Entry" class="delete">Delete</a></td>
						</tr>
						<tr>
							<th scope="row" class="check-column"><input type="checkbox" name="entry_id[]" value="1084"></th>
							<td class="indicators column-indicators has-row-actions column-primary" data-colname=""><a href="#" class="indicator-star star" data-id="1084" title="Star entry"><span class="dashicons dashicons-star-filled"></span></a><a href="#" class="indicator-read read" data-id="1084" title="Mark entry read"><span class="dashicons dashicons-marker"></span></a>
								<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
							</td>
							<td class="wpforms_field_0 column-wpforms_field_0" data-colname="Name">John Heiden</td>
							<td class="wpforms_field_1 column-wpforms_field_1" data-colname="Email">JohnCHeiden@example.com</td>
							<td class="wpforms_field_2 column-wpforms_field_2" data-colname="Comment or Message">Fusce consequat dui ut orci tempus cursus. Vivamus ut neque id ipsum tempor???</td>
							<td class="date column-date" data-colname="Date">July 27, 2017</td>
							<td class="actions column-actions" data-colname="Actions"><a href="#" title="View Form Entry" class="view">View</a> <span class="sep">|</span> <a href="#" title="Delete Form Entry" class="delete">Delete</a></td>
						</tr>
						<tr>
							<th scope="row" class="check-column"><input type="checkbox" name="entry_id[]" value="1083"></th>
							<td class="indicators column-indicators has-row-actions column-primary" data-colname=""><a href="#" class="indicator-star star" data-id="1083" title="Star entry"><span class="dashicons dashicons-star-filled"></span></a><a href="#" class="indicator-read read" data-id="1083" title="Mark entry read"><span class="dashicons dashicons-marker"></span></a>
								<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
							</td>
							<td class="wpforms_field_0 column-wpforms_field_0" data-colname="Name">Laura Shuler</td>
							<td class="wpforms_field_1 column-wpforms_field_1" data-colname="Email">LauraDShuler@example.com</td>
							<td class="wpforms_field_2 column-wpforms_field_2" data-colname="Comment or Message">In ac finibus erat. Curabitur sit amet ante nec tellus commodo commodo non ???</td>
							<td class="date column-date" data-colname="Date">July 27, 2017</td>
							<td class="actions column-actions" data-colname="Actions"><a href="#" title="View Form Entry" class="view">View</a> <span class="sep">|</span> <a href="#" title="Delete Form Entry" class="delete">Delete</a></td>
						</tr>
						<tr>
							<th scope="row" class="check-column"><input type="checkbox" name="entry_id[]" value="1082"></th>
							<td class="indicators column-indicators has-row-actions column-primary" data-colname=""><a href="#" class="indicator-star star" data-id="1082" title="Star entry"><span class="dashicons dashicons-star-filled"></span></a><a href="#" class="indicator-read read" data-id="1082" title="Mark entry read"><span class="dashicons dashicons-marker"></span></a>
								<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
							</td>
							<td class="wpforms_field_0 column-wpforms_field_0" data-colname="Name">Walter Sullivan</td>
							<td class="wpforms_field_1 column-wpforms_field_1" data-colname="Email">WalterPSullivan@example.com</td>
							<td class="wpforms_field_2 column-wpforms_field_2" data-colname="Comment or Message">Phasellus semper magna leo, ut porta nibh pretium sed. Interdum et malesuad???</td>
							<td class="date column-date" data-colname="Date">July 27, 2017</td>
											<td class="actions column-actions" data-colname="Actions"><a href="#" title="View Form Entry" class="view">View</a> <span class="sep">|</span> <a href="#" title="Delete Form Entry" class="delete">Delete</a></td>
						</tr>
						<tr>
							<th scope="row" class="check-column"><input type="checkbox" name="entry_id[]" value="1081"></th>
							<td class="indicators column-indicators has-row-actions column-primary" data-colname=""><a href="#" class="indicator-star star" data-id="1081" title="Star entry"><span class="dashicons dashicons-star-filled"></span></a><a href="#" class="indicator-read read" data-id="1081" title="Mark entry read"><span class="dashicons dashicons-marker"></span></a>
								<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
							</td>
							<td class="wpforms_field_0 column-wpforms_field_0" data-colname="Name">Gary Austin</td>
							<td class="wpforms_field_1 column-wpforms_field_1" data-colname="Email">GaryJAustin@example.com</td>
							<td class="wpforms_field_2 column-wpforms_field_2" data-colname="Comment or Message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet ero???</td>
							<td class="date column-date" data-colname="Date">July 27, 2017</td>
							<td class="actions column-actions" data-colname="Actions"><a href="#" title="View Form Entry" class="view">View</a> <span class="sep">|</span> <a href="#" title="Delete Form Entry" class="delete">Delete</a></td>
						</tr>
						<tr>
							<th scope="row" class="check-column"><input type="checkbox" name="entry_id[]" value="1080"></th>
							<td class="indicators column-indicators has-row-actions column-primary" data-colname=""><a href="#" class="indicator-star star" data-id="1080" title="Star entry"><span class="dashicons dashicons-star-filled"></span></a><a href="#" class="indicator-read read" data-id="1080" title="Mark entry read"><span class="dashicons dashicons-marker"></span></a>
								<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
							</td>
							<td class="wpforms_field_0 column-wpforms_field_0" data-colname="Name">Mark Frahm</td>
							<td class="wpforms_field_1 column-wpforms_field_1" data-colname="Email">MarkTFrahm@example.com</td>
							<td class="wpforms_field_2 column-wpforms_field_2" data-colname="Comment or Message">Proin euismod tellus quis tortor bibendum, a pulvinar libero fringilla. Cur???</td>
							<td class="date column-date" data-colname="Date">July 27, 2017</td>
							<td class="actions column-actions" data-colname="Actions"><a href="#" title="View Form Entry" class="view">View</a> <span class="sep">|</span> <a href="#" title="Delete Form Entry" class="delete">Delete</a></td>
						</tr>
						<tr>
							<th scope="row" class="check-column"><input type="checkbox" name="entry_id[]" value="1079"></th>
							<td class="indicators column-indicators has-row-actions column-primary" data-colname=""><a href="#" class="indicator-star star" data-id="1079" title="Star entry"><span class="dashicons dashicons-star-filled"></span></a><a href="#" class="indicator-read read" data-id="1079" title="Mark entry read"><span class="dashicons dashicons-marker"></span></a>
								<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
							</td>
							<td class="wpforms_field_0 column-wpforms_field_0" data-colname="Name">Linda Reynolds</td>
							<td class="wpforms_field_1 column-wpforms_field_1" data-colname="Email">LindaJReynolds@example.com</td>
							<td class="wpforms_field_2 column-wpforms_field_2" data-colname="Comment or Message">Cras sodales sagittis maximus. Nunc vestibulum orci quis orci pulvinar vulp???</td>
							<td class="date column-date" data-colname="Date">July 27, 2017</td>
							<td class="actions column-actions" data-colname="Actions"><a href="#" title="View Form Entry" class="view">View</a> <span class="sep">|</span> <a href="#" title="Delete Form Entry" class="delete">Delete</a></td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></td>
							<th scope="col" class="manage-column column-indicators column-primary"></th>
							<th scope="col" class="manage-column column-wpforms_field_0">Name</th>
							<th scope="col" class="manage-column column-wpforms_field_1">Email</th>
							<th scope="col" class="manage-column column-wpforms_field_2">Comment or Message</th>
							<th scope="col" class="manage-column column-date sortable desc"><a href="#"><span>Date</span><span class="sorting-indicator"></span></a></th>
							<th scope="col" class="manage-column column-actions">Actions</th>
						</tr>
					</tfoot>
				</table>
			</form>
			</div>
			</div>
		</div>
		<div class="clear"></div>
		<?php
	}

	/**
	 * Add appropriate styling to addons page.
	 *
	 * @since 1.0.4
	 */
	public function addon_page_enqueues() {

		if ( ! isset( $_GET['page'] ) || 'wpforms-addons' !== $_GET['page'] ) {
			return;
		}

		// JS
		wp_enqueue_script(
			'jquery-matchheight',
			WPFORMS_PLUGIN_URL . 'assets/js/jQuery.matchHeight-min.js',
			array( 'jquery'  ),
			'0.7.0',
			false
		);
	}

	/**
	 * Notify user that addons are a pro feature.
	 *
	 * @since 1.0.0
	 */
	public function addons_page() {

		if ( ! isset( $_GET['page'] ) || 'wpforms-addons' !== $_GET['page'] ) {
			return;
		}

		$upgrade = wpforms_admin_upgrade_link();
		$addons  = array(
			array(
				'name' => 'Aweber',
				'desc' => 'WPForms AWeber addon allows you to create AWeber newsletter signup forms in WordPress, so you can grow your email list.',
				'icon' => 'addon-icon-aweber.png',
			),
			array(
				'name' => 'Campaign Monitor',
				'desc' => 'WPForms Campaign Monitor addon allows you to create Campaign Monitor newsletter signup forms in WordPress, so you can grow your email list.',
				'icon' => 'addon-icon-campaign-monitor.png',
			),
			array(
				'name' => 'Conditional Logic',
				'desc' => 'WPForms\' smart conditional logic addon allows you to show or hide fields, sections, and subscribe to newsletters based on user selections, so you can collect the most relevant information.',
				'icon' => 'addon-icon-conditional-logic.png',
			),
			array(
				'name' => 'Custom Captcha',
				'desc' => 'WPForms custom captcha addon allows you to define custom questions or use random math questions as captcha to combat spam form submissions.',
				'icon' => 'addon-icon-captcha.png',
			),
			array(
				'name' => 'Form Abandonment',
				'desc' => 'Unlock more leads by capturing partial entries from your forms. Easily follow up with interested leads and turn them into loyal customers.',
				'icon' => 'addon-icon-form-abandonment.png',
			),
			array(
				'name' => 'Geolocation',
				'desc' => 'WPForms geolocation addon allows you to collect and store your website visitors geolocation data along with their form submission.',
				'icon' => 'addon-icon-geolocation.png',
			),
			array(
				'name' => 'GetResponse',
				'desc' => 'WPForms GetResponse addon allows you to create GetResponse newsletter signup forms in WordPress, so you can grow your email list.',
				'icon' => 'addon-icon-getresponse.png',
			),
			array(
				'name' => 'MailChimp',
				'desc' => 'WPForms MailChimp addon allows you to create MailChimp newsletter signup forms in WordPress, so you can grow your email list.',
				'icon' => 'addon-icon-mailchimp.png',
			),
			array(
				'name' => 'PayPal Standard',
				'desc' => 'WPForms\' PayPal addon allows you to connect your WordPress site with PayPal to easily collect payments, donations, and online orders.',
				'icon' => 'addon-icon-paypal.png',
			),
			array(
				'name' => 'Post Submissions',
				'desc' => 'WPForms Post Submissions addon makes it easy to have user-submitted content in WordPress. This front-end post submission form allow your users to submit blog posts without logging into the admin area.',
				'icon' => 'addon-icon-post-submissions.png',
			),
			array(
				'name' => 'Stripe',
				'desc' => 'WPForms\' Stripe addon allows you to connect your WordPress site with Stripe to easily collect payments, donations, and online orders.',
				'icon' => 'addon-icon-stripe.png',
			),
			array(
				'name' => 'User Registration',
				'desc' => 'WPForms\' Stripe addon allows you to connect your WordPress site with Stripe to easily collect payments, donations, and online orders.',
				'icon' => 'addon-icon-user-registration.png',
			),
			array(
				'name' => 'Zapier',
				'desc' => 'WPForms\' Zapier addon allows you to connect your WordPress forms with over 500+ web apps. The integration possibilities here are just endless..',
				'icon' => 'addon-icon-zapier.png',
			),
		)
		?>
		<div id="wpforms-admin-addons" class="wrap wpforms-admin-wrap">
			<h1 class="page-title">WPForms Addons</h1>
			<div class="notice notice-info" style="display: block;">
				<p><strong>Form Addons are a PRO feature.</strong></p>
				<p>Please upgrade to the PRO plan to unlock them and more awesome features.</p>
				<p><a href="https://wpforms.com/lite-upgrade/?utm_source=WordPress&amp;utm_medium=link&amp;utm_campaign=liteplugin" class="wpforms-btn wpforms-btn-orange wpforms-btn-md">Upgrade Now</a></p>
			</div>
			<div class="wpforms-admin-content">
				<div class="addons-container">
					<?php foreach ( $addons as $addon ) : ?>
					<div class="addon-container">
						<div class="addon-item">
							<div class="details wpforms-clear" style=""><img src="https://wpforms.com/images/<?php echo $addon['icon']; ?>">
								<h5><?php echo $addon['name']; ?> Addon</h5>
								<p><?php echo $addon['desc']; ?></p>
							</div>
							<div class="actions wpforms-clear">
								<div class="upgrade-button"><a href="<?php echo $upgrade; ?>" target="_blank" rel="noopener noreferrer" class="wpforms-btn wpforms-btn-light-grey wpforms-upgrade-modal">Upgrade Now</a></div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
					<div style="clear:both;"></div>
				</div>
			</div>
		</div>
		<?php
	}
}

new WPForms_Lite;
