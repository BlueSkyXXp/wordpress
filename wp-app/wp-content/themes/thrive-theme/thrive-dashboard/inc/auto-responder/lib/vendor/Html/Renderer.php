<?php

/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-dashboard
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

/**
 * maybe we can use this to generate the actual form fields ?
 *
 * Class Thrive_Dash_Api_Html_Renderer
 */
class Thrive_Dash_Api_Html_Renderer {
	protected $show_display_options = false;
	protected $show_order = false;
	protected $connection_config = array();

	/**
	 * render all available API fields
	 */
	public function getApiFields() {

		$account = isset( $this->connection_config['wordpress'] );

		$fields = array(
			'name'  => array(
				'display'  => 1,
				'type'     => 'text',
				'name'     => 'name',
				'label'    => __( 'Name', 'thrive-dash' ),
				'required' => false,
			),
			'email' => array(
				'display'    => 1,
				'type'       => 'email',
				'name'       => 'email',
				'label'      => __( 'Email', 'thrive-dash' ),
				'validation' => 'email',
				'required'   => true,
			),
			'phone' => array(
				'display'    => 1,
				'type'       => 'text',
				'name'       => 'phone',
				'label'      => __( 'Phone Number', 'thrive-dash' ),
				'validation' => 'phone',
			),
		);

		if ( $account ) {
			$fields['password']         = array(
				'display'    => 0,
				'type'       => 'password',
				'name'       => 'password',
				'label'      => __( 'Password', 'thrive-dash' ),
				'validation' => 'password',
				'required'   => false,
			);
			$fields['confirm_password'] = array(
				'display'    => 0,
				'type'       => 'password',
				'name'       => 'confirm_password',
				'label'      => __( 'Confirm Password', 'thrive-dash' ),
				'validation' => 'password',
				'required'   => false,
			);
		}

		/**
		 * allow adding / removing fields from the form
		 */
		$fields = apply_filters( 'tcb_lead_generation_api_fields', $fields );

		return $fields;
	}

	/**
	 * generate the setup table for the fields included in API-connected forms
	 *
	 * @param array $params provide a way to filter the output
	 * @param array $order elements order - numeric array containing field names as values
	 *
	 * @return string the generated table containing all input data
	 */
	public function apiFieldsTable( $params = array(), $order = array(), $connection_config ) {
		$this->connection_config    = $connection_config;
		$this->show_display_options = empty( $params['show_display_options'] ) ? false : true;
		$this->show_order           = empty( $params['show_order'] ) ? false : true;

		$fields = $this->getOrderedFields( $order );

		return $this->fieldsTable( $fields );
	}

	/**
	 * get the ordered list of fields
	 *
	 * @param array $order elements order - numeric array containing field names as values
	 *
	 * @return array
	 */
	public function getOrderedFields( $order ) {
		$fields = $this->getApiFields();

		if ( ! empty( $order ) ) {
			$ordered = array();
			foreach ( $order as $field ) {
				if ( ! isset( $fields[ $field ] ) ) {
					continue;
				}
				$ordered[ $field ] = $fields[ $field ];
				unset( $fields[ $field ] );
			}
			/**
			 * take on any other fields
			 */
			foreach ( $fields as $k => $f ) {
				$ordered[ $k ] = $f;
			}
			$fields = $ordered;
		}

		return $fields;
	}

	/**
	 * render the table containing all fields (inside the editor view / panel)
	 *
	 * @param array $elements
	 *
	 * @return string the table containing the setup fields
	 */
	public function fieldsTable( $elements = array() ) {
		$html = '<table class="tve_autoresponder_table">';
		$html .= $this->_tableHead() . '<tbody>';
		$input_index = 1;
		foreach ( $elements as $element ) {
			switch ( $element['type'] ) {
				case 'text':
				case 'password':
				case 'email':
					$html .= $this->_textRow( $element, $input_index, 'text' );
					break;
				case 'radio':
					$html .= $this->_radioRow( $element, $input_index );
					break;
				case 'checkbox':
					$html .= $this->_checkboxRow( $element, $input_index );
					break;
				case 'select':
					$html .= $this->_selectRow( $element, $input_index );
					break;
				case 'textarea':
					$html .= $this->_textareaRow( $element, $input_index );
					break;
			}
			$input_index ++;
		}

		$html .= '</tbody></table>';

		return $html;
	}

	/**
	 * render the table head
	 *
	 * @return string
	 */
	protected function _tableHead() {
		ob_start();
		?>
		<thead>
	<tr>
		<?php if ( $this->show_order ) : ?>
			<th style="width: 1%;">&nbsp;</th><?php endif ?>
		<th style="width: 10%; text-align: center"><?php echo $this->show_display_options ? esc_html__( 'Display', 'thrive-dash' ) : esc_html__( 'Field Number', 'thrive-dash' ); ?></th>
		<th style="width: 17%;"><?php echo esc_html__( "Field Properties", 'thrive-dash' ); ?></th>
		<th style="width: 23%;"><?php echo esc_html__( "Field Label / Description", 'thrive-dash' ); ?></th>
		<th style="width: 16%;"><?php echo esc_html__( "Validation", 'thrive-dash' ) ?></th>
		<th style="width: 10%;"><?php echo esc_html__( "Required Field", 'thrive-dash' ); ?></th>
		<th><?php echo esc_html__( 'Show Icon', 'thrive-dash' ) ?></th>
	</tr></thead><?php
		$head = ob_get_contents();
		ob_end_clean();

		return $head;
	}

	/**
	 * render a row for a text input
	 *
	 * @param array $element the element data
	 * @param int $input_index
	 *
	 * @return string
	 */
	protected function _textRow( $element, $input_index, $type = 'text' ) {
		$field_name = $field = $element['name'];
		$field      = $this->encodeAttrName( $field );
		ob_start();
		?>
		<tr>
		<?php if ( $this->show_order ) : ?>
			<td class="tcb-text-center"><span class="tve_icm tve-ic-move tve-drag-handle"></span></td><?php endif ?>
		<td class="tve_text_center">
			<?php if ( $this->show_display_options ) : ?>
				<?php if ( $field != 'email' ) : ?>
					<label class="tve_switch">
						<input class="tve-lg-display-elem tve_lightbox_input" data-elem-field="display" type="checkbox"
							   id="<?php echo esc_attr( 'elem_display_' . $field ); ?>"<?php echo ! empty( $element['display'] ) ? ' checked="checked"' : '' ?> />
						<span></span>
					</label>
				<?php else : ?>
					-
				<?php endif ?>
			<?php else :
				echo esc_html( $input_index );
			endif ?></td>
		<td>
			<?php echo isset( $element['label'] ) ? $element['label'] : ucfirst( $field_name ) ?>
			<input type="hidden" class="lg_elem_field" value="<?php echo esc_attr( $field ) ?>"/>
		</td>
		<td>
			<input type="<?php echo esc_attr( $type ); ?>" data-elem-field="label" value="<?php echo empty( $element['label'] ) ? '' : esc_attr( $element['label'] ) ?>" class='tve_lightbox_input'
				   id='txt_label_<?php echo esc_attr( $field ); ?>'/>
		</td>
		<td>
			<div class="tve_lightbox_select_holder">
				<?php $this->_validationOptions( $field, $element ) ?>
			</div>
		</td>
		<td class="tve_text_center">
			<div class="tve_lightbox_input_holder tve_lightbox_no_label">
				<input data-elem-field="required" type="checkbox"<?php echo ! empty( $element['required'] ) ? ' checked="checked"' : '' ?> id="required_<?php echo esc_attr( $field ) ?>"/>
				<label for="required_<?php echo esc_attr( $field ) ?>"></label>
			</div>
		</td>
		<td>
			<div class="tve_lightbox_input_holder tve_lightbox_no_label">
				<input data-elem-field="show_icon" type="checkbox" id="icon_<?php echo esc_attr( $field ); ?>:"/>
				<label for="icon_<?php echo esc_attr( $field ); ?>:"></label>
			</div>
			<button class="tve_editor_button tve_editor_button_default tve_lightbox_input_inline tve_click tve_editor_small_button"
				data-ctrl="function:auto_responder.open_icon_picker"
				data-field="<?php echo esc_attr( $field ); ?>"><?php echo esc_html__( 'Add icon', 'thrive-dash' ) ?></button>
		</td></tr><?php
		$row = ob_get_contents();
		ob_end_clean();

		return $row;
	}

	/**
	 * render a row for a select (dropdown) element
	 *
	 * @param array $element element data
	 * @param int $input_index
	 *
	 * @return string
	 */
	protected function _selectRow( $element, $input_index ) {
		$field_name = $field = $element['name'];
		$field      = $this->encodeAttrName( $field );
		ob_start();
		?>
		<tr class="tcb-row-hover">
		<?php if ( $this->show_order ) : ?>
			<td class="tcb-text-center"><span class="tve_icm tve-ic-move tve-drag-handle"></span></td><?php endif ?>
		<td class="tve_text_center"><?php echo esc_html( $input_index ); ?></td>
		<td>
			<?php echo isset( $element['label'] ) ? esc_html( $element['label'] ) : esc_html( ucfirst( $field_name ) ) ?>
			<input type="hidden" class="lg_elem_field" value="<?php echo esc_attr( $field ); ?>:"/>
		</td>
		<td>
			<input type="text" data-elem-field="label"
				   value="<?php echo empty( $element['default_value'] ) ? '' : esc_attr( $element['default_value'] ) ?>"
				   class='tve_lightbox_input'
				   id='txt_label_<?php echo esc_attr( $field ); ?>'/>
		</td>
		<td style="text-align: center">&nbsp;</td>
		<td class="tve_text_center">
			<div class="tve_lightbox_input_holder tve_lightbox_no_label">
				<input data-elem-field="required"
					   type="checkbox"<?php echo ! empty( $element['required'] ) ? ' checked="checked"' : '' ?>
					   id="required_<?php echo esc_attr( $field ); ?>:"/>
				<label for="required_<?php echo esc_attr( $field ); ?>:"></label>
			</div>
		</td>
		<td class="tve_center">
			-
			<input data-elem-field="show_icon" type="checkbox" id="icon_<?php echo esc_attr( $field ); ?>:"
				   style="display: none"/>
		</td>
		</tr><?php
		$row = ob_get_contents();
		ob_end_clean();

		return $row;
	}

	/**
	 * render a row for a radio input element
	 *
	 * @param array $element element data
	 * @param int $input_index
	 *
	 * @return string
	 */
	protected function _radioRow( $element, $input_index ) {
		$field_name = $field = $element['name'];
		$field      = $this->encodeAttrName( $field );
		ob_start();
		?>
		<tr class="tcb-row-hover">
		<?php if ( $this->show_order ) : ?>
			<td class="tcb-text-center"><span class="tve_icm tve-ic-move tve-drag-handle"></span></td><?php endif ?>
		<td class="tve_text_center"><?php echo esc_html( $input_index ); ?></td>
		<td>
			<?php echo isset( $element['label'] ) ? esc_html( $element['label'] ) : esc_html( ucfirst( $field_name ) ) ?>
		</td>
		<td>
			<?php foreach ( $element['options'] as $encoded_value => $radio_label ) : ?>
				<input type="text" value="<?php echo esc_attr( $radio_label ) ?>"
					   class="tve_lightbox_input"
					   id="txt_label_<?php echo esc_attr( $field . '_' . $encoded_value ); ?>"/>
			<?php endforeach; ?>
		</td>
		<td style="text-align: center">&nbsp;</td>
		<td class="tve_text_center">
			<div class="tve_lightbox_input_holder tve_lightbox_no_label">
				<input data-elem-field="required"
					   type="checkbox"<?php echo ! empty( $element['required'] ) ? ' checked="checked"' : '' ?>
					   id="required_<?php echo esc_attr( $field ); ?>:"/>
				<label for="required_<?php echo esc_attr( $field ); ?>:"></label>
			</div>
		</td>
		<td>&nbsp;</td>
		</tr><?php
		$row = ob_get_contents();
		ob_end_clean();

		return $row;
	}

	/**
	 * render a row for a checkbox element
	 *
	 * @param array $element
	 * @param int $input_index
	 *
	 * @return string
	 */
	protected function _checkboxRow( $element, $input_index ) {
		$field_name = $field = $element['name'];
		$field      = $this->encodeAttrName( $field );
		ob_start();
		?>
		<tr class="tcb-row-hover">
		<?php if ( $this->show_order ) : ?>
			<td class="tcb-text-center"><span class="tve_icm tve-ic-move tve-drag-handle"></span></td><?php endif ?>
		<td class="tve_text_center"><?php echo esc_html( $input_index ); ?></td>
		<td>
			<?php echo isset( $element['label'] ) ? esc_html( $element['label'] ) : esc_html( ucfirst( $field_name ) ) ?>
		</td>
		<td>
			<input data-elem-field="label" type="text" value="<?php echo esc_attr( $element['value'] ) ?>"
				   class='tve_lightbox_input'
				   id='txt_label_<?php echo esc_attr( $field ); ?>'/>
		</td>
		<td style="text-align: center">&nbsp;</td>
		<td class="tve_text_center">
			<div class="tve_lightbox_input_holder tve_lightbox_no_label">
				<input data-elem-field="required"
					   type="checkbox"<?php echo ! empty( $element['required'] ) ? ' checked="checked"' : '' ?>
					   id="required_<?php echo esc_attr( $field ); ?>:"/>
				<label for="required_<?php echo esc_attr( $field ); ?>:"></label>
			</div>
		</td>
		<td>&nbsp;</td>
		</tr><?php
		$row = ob_get_contents();
		ob_end_clean();

		return $row;
	}

	/**
	 * render a row for a textarea element
	 *
	 * @param array $element element data
	 * @param int $input_index
	 *
	 * @return string
	 */
	protected function _textareaRow( $element, $input_index ) {
		return $this->_textRow( $element, $input_index );
	}

	/**
	 * output validation options
	 *
	 * @param string $field
	 * @param array $element element data
	 */
	protected function _validationOptions( $field, $element ) {
		$selected = ! empty( $element['validation'] ) ? $element['validation'] : '';
		$account  = isset( $this->connection_config['wordpress'] );

		?><select id="validation_<?php echo esc_attr( $field ); ?>:" class="tve_lg_validation_options" data-elem-field="validation">
		<option value="none"><?php echo esc_html__( "None", 'thrive-dash' ) ?></option>
		<option value="email"<?php echo $selected == 'email' ? ' selected="selected"' : '' ?>><?php echo esc_html__( 'Email', 'thrive-dash' ) ?></option>
		<option value="phone"<?php echo $selected == 'phone' ? ' selected="selected"' : '' ?>><?php echo esc_html__( 'Phone number', 'thrive-dash' ) ?></option>
		<?php if ( $account ) : ?>
			<option value="password"<?php echo $selected == 'password' ? ' selected="selected"' : '' ?>><?php echo esc_html__( 'Password', 'thrive-dash' ) ?></option>
		<?php endif; ?>
		</select><?php	}

	/**
	 * replace all special (css meaning) characters with codes
	 *
	 * @param string $attr
	 *
	 * @return string
	 */
	public function encodeAttrName( $attr ) {
		$attr = str_replace( "[", "_tbl_", $attr );
		$attr = str_replace( "]", "_tbr_", $attr );
		$attr = str_replace( "(", "_tbl2_", $attr );
		$attr = str_replace( ")", "_tbr2_", $attr );
		$attr = str_replace( " ", "_tsp_", $attr );
		$attr = str_replace( ".", "_tspnt_", $attr );
		$attr = str_replace( "/", "_ts_", $attr );
		$attr = str_replace( ",", "_tc_", $attr );
		$attr = str_replace( ":", "_tcol_", $attr );
		$attr = str_replace( "==", "_teql_", $attr );

		return $attr;
	}

	/**
	 * decode attribute name
	 *
	 * @param string $attr
	 *
	 * @return string
	 */
	public function decodeAttrName( $attr ) {
		$attr = str_replace( "_tbl_", "[", $attr );
		$attr = str_replace( "_tbr_", "]", $attr );
		$attr = str_replace( "_tbl2_", "(", $attr );
		$attr = str_replace( "_tbr2_", ")", $attr );
		$attr = str_replace( "_tsp_", " ", $attr );
		$attr = str_replace( "_tspnt_", ".", $attr );
		$attr = str_replace( "_ts_", "/", $attr );
		$attr = str_replace( "_tc_", ",", $attr );
		$attr = str_replace( "_tcol_", ":", $attr );
		$attr = str_replace( "_teql_", "==", $attr );

		return $attr;
	}
}
