<?php

function uthsc_wpcas_preferences() {
	
?>

	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>

		<h2>UTHSC WPCAS Preferences</h2>

		<?php 
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'cas-configuration';  
		?>

		<h2 class="nav-tab-wrapper">  
		  <a href="?page=uthsc-wpcas-settings&tab=cas-configuration" class="nav-tab <?php echo $active_tab == 'cas-configuration' ? 'nav-tab-active' : ''; ?> ">CAS Configuration</a>  
		  <a href="?page=uthsc-wpcas-settings&tab=uthsc-wpcas-options" class="nav-tab <?php echo $active_tab == 'uthsc-wpcas-options' ? 'nav-tab-active' : ''; ?> ">WPCAS Options</a>  
		</h2> 

		<form method="post" action="options.php">
			<?php
				
			if( $active_tab == 'cas-configuration' ) {
				
				settings_fields( 'uthsc-wpcas-configuration' );
				
				?>

				<fieldset>
					<h3>CAS Host</h3>
					<p>Defaults to "auth.uthsc.edu"</p>
					<ul>
						<li>
							<label for="wpcas_host">CAS Host</label>
							<input 
								type="text" 
								name="wpcas_host" 
								value="<?php echo get_option('wpcas_host')?>"
								id="wpcas_host" 
								/>
							
						</li>
					</ul>
				</fieldset>

				<fieldset>
					<h3>CAS Context</h3>
					<p>Defaults to "/cas"</p>
					<ul>
						<li>
							<label for="wpcas_context">CAS Context</label>
							<input 
								type="text" 
								name="wpcas_context" 
								value="<?php echo get_option('wpcas_context')?>"
								id="wpcas_context" 
								/>
							
						</li>
					</ul>
				</fieldset>

				<fieldset>
					<h3>CAS Port</h3>
					<p>Defaults to 443</p>
					<ul>
						<li>
							<label for="wpcas_port">CAS Port</label>
							<input
								type="text" 
								name="wpcas_port" 
								value="<?php echo get_option('wpcas_port')?>"
								id="wpcas_port" 
							/>
						</li>
					</ul>
				</fieldset>

				<fieldset>
					<h3>CAS Certificate Path</h3>
					<p>Path to CAS Cert</p>
					<ul>
						<li>
							<label for="wpcas_cert_path">CAS Cert Path</label>
							<input
								size="70"
								type="text" 
								name="wpcas_cert_path" 
								value="<?php echo get_option('wpcas_cert_path')?>"
								id="wpcas_cert_path" 
								/>
							
						</li>
					</ul>
				</fieldset>

				<fieldset>
					<h3>CAS Attributes</h3>
					<p>Array indexes returned by cas that will be used as args for wp_insert() when new users are created. WordPress username will use uid returned by CAS.</p>
					<ul>
						<li>
							<label for="wpcas_first_name">First Name</label>
							<input
								type="text"
								name="wpcas_first_name"
								value="<?php echo get_option('wpcas_first_name')?>"
								id="wpcas_first_name"
							/>
						</li>

						<li>
							<label for="wpcas_last_name">Last Name</label>
							<input
								type="text"
								name="wpcas_last_name"
								value="<?php echo get_option('wpcas_last_name')?>"
								id="wpcas_last_name"
							/>
						</li>

						<li>
							<label for="wpcas_user_email">Email</label>
							<input
								type="text"
								name="wpcas_user_email"
								value="<?php echo get_option('wpcas_user_email')?>"
								id="wpcas_user_email"
							/>
						</li>

					</ul>
				</fieldset>

				<?php

			} else {

				settings_fields( 'uthsc-wpcas-plugin-options' );

				?>

				<h2>Work in Progress</h2>
				<p>None of these settings do anything yet; these are just ideas right now and should be relatively easy to add.<br />
				If you have ideas or would like to contribute check out the <a href="https://github.com/uthsc/uthsc-wpcas">UTHSC-WPCAS Repo</a> on GitHub</p>

				<fieldset>
					<h3>To Do: CAS Lockdown</h3>
					<p>If this is turned on, users will be forced to log in to see the site</p>
					<ul>
						<li>
								<label for="wpcas-lockdown-off">Off</label>
								<input type="radio" name="wpcas_lockdown" id="wpcas-lockdown-off" value="off" <?php  echo get_option('wpcas_lockdown') == 'off' ? 'checked="checked"' : '' ?> />
								<label for="wpcas-lockdown-on">On</label>
								<input type="radio" name="wpcas_lockdown" id="wpcas-lockdown-on" value="on"  <?php  echo get_option('wpcas_lockdown') == 'on' ? 'checked="checked"' : '' ?> />
						</li>
					</ul>
				</fieldset>

				<fieldset>
					<h3>To Do: Restrict New Users</h3>
					<p>Users must already have a WordPress account on the site to login<br /></p>
					<ul>
						<li>
								<label for="wpcas-restrict-new-users-off">Off</label>
								<input type="radio" name="wpcas_restrict_new_users" id="wpcas-restrict-new-users-off" value="off" <?php  echo get_option('wpcas_restrict_new_users') == 'off' ? 'checked="checked"' : '' ?> />
								<label for="wpcas-restrict-new-users-on">On</label>
								<input type="radio" name="wpcas_restrict_new_users" id="wpcas-restrict-new-users-on" value="on"  <?php  echo get_option('wpcas_restrict_new_users') == 'on' ? 'checked="checked"' : '' ?> />
						</li>
					</ul>
				</fieldset>

				<fieldset>
					<h3>To Do: Update WordPress Account on Login</h3>
					<p>Checks WordPress account attributes against attributes returned by CAS and updates them if they are different.</p>
					<ul>
						<li>
								<label for="wpcas-update-acct-off">Off</label>
								<input type="radio" name="wpcas_update_acct" id="wpcas-update-acct-off" value="off" <?php  echo get_option('wpcas_update_acct') == 'off' ? 'checked="checked"' : '' ?> />
								<label for="wpcas-update-acct-on">On</label>
								<input type="radio" name="wpcas_update_acct" id="wpcas-update-acct-on" value="on"  <?php  echo get_option('wpcas_update_acct') == 'on' ? 'checked="checked"' : '' ?> />
						</li>
					</ul>
				</fieldset>

				<?php	

			} // end if/else

			submit_button();

			?>

		</form>

	</div>

	<?php

} //close admin options page