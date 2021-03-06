<?php

namespace WTS_EAE\Modules\InfoCircle\Skins;

use Elementor\Widget_Base;
use Elementor\Group_Control_Border;

class Skin_1 extends Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions(); // TODO: Change the autogenerated stub
		add_action( 'elementor/element/eae-info-circle/skin1_icon_global_style/after_section_end', [ $this, 'extra_controls_update' ] );
		add_action( 'elementor/element/eae-info-circle/skin1_content_styling/after_section_start', [ $this, 'control_add' ] );
	}

	public function get_id() {
		return 'skin1';
	}

	public function control_add() {
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'item_border',
				'label'          => __( 'Border', 'wts-eae' ),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top'    => 10,
							'right'  => 10,
							'bottom' => 10,
							'left'   => 10,
						],
					],
					'color' => [
						'default' => '#6ec1e4',
					],
				],
				'selector'       =>
					'{{WRAPPER}} .eae-info-circle:before',
			]
		);
	}
	public function extra_controls_update() {
		$this->update_control(
			'item_icon_icon_padding',
			[
				'default' => [
					'size' => 10,
				],
			]
		);
		$this->update_control(
			'item_icon_icon_size',
			[
				'default' => [
					'size' => 20,
				],
			]
		);

		$this->update_control(
			'item_icon_border_width',
			[
				'default' => [
					'top'    => 10,
					'right'  => 10,
					'bottom' => 10,
					'left'   => 10,
				],
			]
		);
	}
	public function get_title() {
		return __( 'Skin 1', 'wts-eae' );
	}
	public function register_common_controls( Widget_Base $widget ) {
		$this->parent = $widget;
	}
	public function register_style_controls() {
		$this->eae_infocircle_style_section();
	}
	public function render() {
		$this->common_render();
	}
}
