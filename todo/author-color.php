<?php
add_action( 'show_user_profile', 'color_selector' );
add_action( 'edit_user_profile', 'color_selector' );
function color_selector( $user ) {
  $color = get_the_author_meta( '_color', $user->ID );
  ?>



  <table class="form-table">
<tbody><tr >
	<th><label for="_super_user">Color</label></th>
	<td><input type="text" name="_color" value="<?php echo $color;?>">
		</td>
</tr>


</tbody></table>

<?php }
add_action( 'personal_options_update', 'save_user_color' );
add_action( 'edit_user_profile_update', 'save_user_color' );
function save_user_color( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, '_color', $_POST['_color'] );
}


  ?>
<?php
add_action( 'show_user_profile', 'connect_calendar' );
add_action( 'edit_user_profile', 'connect_calendar' );
function connect_calendar( $user ) {
  $calApi = get_the_author_meta( '_calendarapi', $user->ID );
  ?>

  <table class="form-table">
<tbody><tr >
	<th><label >Google Calendar</label></th>
	<td>
	<?php
	if(empty($calApi)) {
	?>
		<a class="button button-primary" href="#" target="_blank">Connect Now!</a>
	<?php
		
	} else {
		?>
		You're connected!
		<?php
	}
	
	?>
	</td>
</tr>


</tbody></table>

<?php }?>
