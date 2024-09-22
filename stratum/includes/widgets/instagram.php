<?php
/**
 * Class: Stratum_Instagram
 * Name: Instagram
 * Slug: stratum-instagram
 */

namespace Stratum;

// use \Stratum\Stratum_Widget_Base;

use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Instagram extends Stratum_Widget_Base {
	protected $widget_name = 'instagram';

    public function __construct($data = [], $args = null) {
        parent::__construct( $data, $args );
    }

	public function get_title() {
		return esc_html__( 'Instagram', 'stratum' );
	}

    public function get_script_depends() {
        return [
			'anim-on-scroll',
			'modernizr-custom',
		];
	}

	public function get_style_depends() {
        return [
			'scroll-anim-effects',
        ];
	}

	public function get_icon() {
		return 'stratum-icon-instagram';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
	}

	protected function register_controls() {
		$controls = $this;

		/*-----------------------------------------------------------------------------------*/
        /*	Content Tab
        /*-----------------------------------------------------------------------------------*/

		$controls->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'stratum' ),
				'tab'   => Controls_Manager::TAB_CONTENT
			]
		);

		$controls->add_control(
			'items',
			[
				'label' => esc_html__( 'Number of items', 'stratum' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 1,
				'max'   => 100,
				'step'   => 1,
				'default' => 6
			]
		);

		$stratum_api = get_option( 'stratum_api', [] );
		$access_token = isset( $stratum_api['instagram_access_token'] ) ? $stratum_api['instagram_access_token'] : '';

		if (empty($access_token)){
			$controls->add_control(
				'api_key',
				[
					'label' => esc_html__( 'API KEY', 'stratum' ),
					'label_block' => true,
					'type' => Controls_Manager::RAW_HTML,
					'raw' => wp_kses(
						sprintf(
							__( 'Instagram Access Token is not set. <a href="%s" target="_blank">Connect Instagram Account</a>.', 'stratum' ),
							admin_url( 'admin.php?page=stratum-settings#stratum_api' )
						),
						array( 'a' => array( 'href' => array(), 'target' => array() ) )
					),
					'content_classes' => 'api-key-description',
				]
			);
		}

		$controls->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
        /*	Style Tab
        /*-----------------------------------------------------------------------------------*/

		$controls->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$controls->add_control(
			'animate_on_scroll',
			[
				'label' => esc_html__( 'Animate on scroll', 'stratum' ),
				'type'  => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$controls->add_control(
			'animation_effects',
			[
				'label' => esc_html__( 'Animation Effect', 'stratum' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'effect-2',
				'options' => [
					'effect-1' => esc_html__( 'Opacity', 'stratum' ),
					'effect-2' => esc_html__( 'Move Up', 'stratum' ),
					'effect-3' => esc_html__( 'Scale up', 'stratum' ),
					'effect-4' => esc_html__( 'Fall perspective', 'stratum' ),
					'effect-5' => esc_html__( 'Fly', 'stratum' ),
					'effect-6' => esc_html__( 'Flip', 'stratum' ),
					'effect-7' => esc_html__( 'Helix', 'stratum' ),
					'effect-8' => esc_html__( 'Zoom In 3D', 'stratum' ),
				],
				'condition' => [
					'animate_on_scroll' => 'yes',
				],
			]
		);

		$controls->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'stratum' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 1,
				'max'   => 6,
				'step'  => 1,
				'default' => 3,
				'selectors' => [
					'{{WRAPPER}} .stratum-instagram .stratum-instagram__wrapper' => '--columns: {{VALUE}}',
				],
			]
		);

		$controls->add_responsive_control(
			'padding_item',
			[
				'label' => esc_html__( 'Spacing', 'stratum' ),
				'description' => esc_html__( 'In Pixels (px)', 'stratum' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'tablet_default' => [
					'size' => 5,
				],
				'mobile_default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .stratum-instagram .stratum-instagram__item' => 'padding: {{SIZE}}px',
					'{{WRAPPER}} .stratum-instagram .stratum-instagram__wrapper' => 'margin: -{{SIZE}}px',
				],
			]
		);

		$controls->start_controls_tabs( 'instagram_styles' );

			$controls->start_controls_tab(
				'instagram_normal',
				array(
					'label' => esc_html__( 'Normal', 'stratum' ),
				)
			);

				$controls->add_control(
					'background_color',
					[
						'label' => esc_html__( 'Background Color', 'stratum' ),
						'type' => Controls_Manager::COLOR,
						'value' => '#00000000',
						'default' => '#00000000',
						'selectors' => [
							'{{WRAPPER}} .stratum-instagram .stratum-instagram__media-link:before' => 'background-color: {{VALUE}}',
						],
					]
				);

			$controls->end_controls_tab();

			$controls->start_controls_tab(
				'instagram_hover',
				array(
					'label' => esc_html__( 'Hover', 'stratum' ),
				)
			);

				$controls->add_control(
					'background_hover_color',
					[
						'label' => esc_html__( 'Background Color', 'stratum' ),
						'type' => Controls_Manager::COLOR,
						'value' => '#0000002e',
						'default' => '#0000002e',
						'selectors' => [
							'{{WRAPPER}} .stratum-instagram .stratum-instagram__media-link:hover:before' => 'background-color: {{VALUE}}',
						],
					]
				);

			$controls->end_controls_tab();

		$controls->end_controls_tabs();

		$controls->end_controls_section();
	}
	protected function render( $instance = [] ) {

		$media = $this->get_media();

		if ( ! $media['success'] ) {
			?><p><?php
				echo wp_kses(
					$media['error'],
					array( 'a' => array( 'href' => array(), 'target' => array() ) )
				)
			?></p><?php
			return;
		}

		$this->render_widget( 'php', [ 'media' => $media['media'] ] );
	}

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}

	private function get_media() {

		$instagram_media = get_transient( 'stratum_instagram_response_data' );
		$success = true;
		$error = '';

		// @todo: remove in next release
		// added for backward compatibility
		if ( isset( $instagram_media->data ) ) {
			$instagram_media = $instagram_media->data;
		}

		if ( false === $instagram_media ) {

			$encryption = new String_Encryption();
			$stratum_api = get_option( 'stratum_api', [] );
			$access_token = isset( $stratum_api['instagram_access_token'] ) ? $encryption->decrypt( $stratum_api['instagram_access_token'] ) : '';

			//If Empty Token
			if ( empty( $access_token ) ) {
				if ( current_user_can( 'manage_options' ) ) {
					$error = sprintf(
						__( 'Instagram Access Token is not set. <a href="%s" target="_blank">Connect Instagram Account</a>.', 'stratum' ),
						admin_url( 'admin.php?page=stratum-settings#stratum_api' )
					);
				}

				return array(
					'success' => false,
					'error' => $error,
					'media' => $instagram_media
				);
			}

			//Get data from Instagram
			$response = wp_remote_get(
				'https://graph.instagram.com/me/media?fields=id,media_type,media_url,permalink,caption,thumbnail_url,children{media_url,thumbnail_url}&access_token=' . $access_token . '&limit=100',
				array( 'timeout' => 15 )
			);

			if ( is_wp_error( $response ) ) {
				$success = false;
				if ( current_user_can( 'manage_options' ) ) {
					$error = $response->get_error_message();
				}
			} else {
				$instagram_media = json_decode( wp_remote_retrieve_body( $response ) );
				//JSON valid
				if ( json_last_error() === JSON_ERROR_NONE ) {
					if ( isset( $instagram_media->error ) ) {
						$success = false;
						$error = sprintf(
							__( 'The access token could not be decrypted. Your access token is currently invalid. <a href="%s" target="_blank">Please re-authorize your Instagram account</a>.', 'stratum' ),
							admin_url( 'admin.php?page=stratum-settings#stratum_api' )
						);

					} else {
						if ( $instagram_media->data ) {
							$instagram_media = $instagram_media->data;
							//Cache response
							set_transient( 'stratum_instagram_response_data', $instagram_media, 30 * MINUTE_IN_SECONDS );
						} else {
							$success = false;
							if ( current_user_can( 'manage_options' ) ) {
								$error = $instagram_media->meta->error_message;
							}
						}
					}
				} else {
					$success = false;
					$error = __( 'Error in json_decode.', 'stratum' );
				}
			}
		}

		return array(
			'success' => $success,
			'error' => $error,
			'media' => $instagram_media
		);
	}

}

Plugin::instance()->widgets_manager->register( new Instagram() );
