<td class="tvd-error-entry-api_data">
	<span class="tvd-normal">
		<#= item.get( 'fields_html' ) #>
	</span>
</td>
<td class="tvd-error-entry-connection">
	<span class="tvd-normal">
		<#- item.get( 'connection_explicit' ) #>
	</span>
</td>
<td class="tvd-error-entry-date">
	<span class="tvd-normal">
		<#- item.get( 'date' ) #>
	</span>
</td>
<td class="tvd-error-entry-error_message">
	<span class="tvd-normal">
		<#- item.get( 'error_message' ) #>
	</span>
</td>
<td class="tvd-error-entry-actions" data-log-id="<#= item.get( 'id' ) #>">
	<div class="row-actions visible tvd-center-align">
		<# if ( item.get( 'connection_type' ) !== 'storage' ) { #>
			<span class="retry">
				<span class="tvd-icon-loop2 tvd-tooltipped tvd-logs-icon tvd-logs-icon-repeat"
				      data-position="bottom"
				      data-tooltip="<?php echo esc_html__( 'Retry', 'thrive-dash' ) ?>"></span>
			</span>
		<# } #>
		<span class="delete">
			<span class="tvd-icon-trash-o tvd-tooltipped tvd-logs-icon tvd-logs-icon-delete"
			      data-position="bottom"
			      data-tooltip="<?php echo esc_html__( 'Delete', 'thrive-dash' ) ?>"></span>
		</span>
	</div>
</td>
