<h2 class="tvd-card-title"><?php echo esc_html( $this->get_title() ); ?></h2>
<div class="tvd-row">
	<form class="tvd-col tvd-s12">
		<input type="hidden" name="api" value="<?php echo esc_attr( $this->get_key() ); ?>"/>

		<div class="tvd-input-field">
			<input id="tvd-mm-api-key" type="text" name="connection[url]"
				   value="<?php echo esc_attr( $this->param( 'url' ) ); ?>">
			<label for="tvd-mm-api-key"><?php echo esc_html__( 'API URL', 'thrive-dash' ) ?></label>
		</div>
		<div class="tvd-input-field">
			<input id="tvd-mm-api-key" type="text" name="connection[key]"
				   value="<?php echo esc_attr( $this->param( 'key' ) ); ?>">
			<label for="tvd-mm-api-key"><?php echo esc_html__( 'API key', 'thrive-dash' ) ?></label>
		</div>
		<p><?php echo esc_html__( 'Would you also like to connect to the Transactional Email Service ?', 'thrive-dash' ) ?></p>
		<br/>
		<div class="tvd-col tvd-s12 tvd-m4 tvd-no-padding">
			<p>
				<input class="tvd-new-connection-yes" name="connection[new_connection]" type="radio" value="1"
					   id="tvd-new-connection-yes" <?php echo $this->param( 'new_connection' ) == 1 ? 'checked="checked"' : ''; ?> />
				<label for="tvd-new-connection-yes"><?php echo esc_html__( 'Yes', 'thrive-dash' ); ?></label>
			</p>
		</div>
		<div class="tvd-col tvd-s12 tvd-m4 tvd-no-padding">
			<p>
				<?php $connection = $this->param( 'new_connection' ); ?>
				<input class="tvd-new-connection-no" name="connection[new_connection]" type="radio" value="0"
					   id="tvd-new-connection-no" <?php echo empty( $connection ) || $connection == 0 ? 'checked="checked"' : ''; ?> />
				<label for="tvd-new-connection-no"><?php echo esc_html__( 'No', 'thrive-dash' ); ?></label>
			</p>
		</div>
		<?php $this->display_video_link(); ?>
	</form>
</div>
<div class="tvd-card-action">
	<div class="tvd-row tvd-no-margin">
		<div class="tvd-col tvd-s12 tvd-m6">
			<a class="tvd-api-cancel tvd-btn-flat tvd-btn-flat-secondary tvd-btn-flat-dark tvd-full-btn tvd-waves-effect"><?php echo esc_html__( 'Cancel', 'thrive-dash' ) ?></a>
		</div>
		<div class="tvd-col tvd-s12 tvd-m6">
			<a class="tvd-api-connect tvd-waves-effect tvd-waves-light tvd-btn tvd-btn-green tvd-full-btn"><?php echo esc_html__( 'Connect', 'thrive-dash' ) ?></a>
		</div>
	</div>
</div>

