<?php
/**
 * Event List Widget: Standard List
 *
 * The template is used for displaying the [eo_event] shortcode *unless* it is wrapped around a placeholder: e.g. [eo_event] {placeholder} [/eo_event].
 *
 * You can use this to edit how the output of the eo_event shortcode. See http://docs.wp-event-organiser.com/shortcodes/events-list
 * For the event list widget see widget-event-list.php
 *
 * For a list of available functions (outputting dates, venue details etc) see http://codex.wp-event-organiser.com/
 *
 ***************** NOTICE: *****************
 *  Do not make changes to this file. Any changes made to this file
 * will be overwritten if the plug-in is updated.
 *
 * To overwrite this template with your own, make a copy of it (with the same name)
 * in your theme directory. See http://docs.wp-event-organiser.com/theme-integration for more information
 *
 * WordPress will automatically prioritise the template in your theme directory.
 ***************** NOTICE: *****************
 *
 * @package Event Organiser (plug-in)
 * @since 1.7
 */
global $eo_event_loop,$eo_event_loop_args;

//The list ID / classes
$id = ( $eo_event_loop_args['id'] ? 'id="'.$eo_event_loop_args['id'].'"' : '' );
$classes = $eo_event_loop_args['class'];

?>

<?php if ( $eo_event_loop->have_posts() ) :  ?>

		<?php while ( $eo_event_loop->have_posts() ) :  $eo_event_loop->the_post(); ?>

			<?php
				//Generate HTML classes for this event
				$eo_event_classes = eo_get_event_classes();

				//For non-all-day events, include time format
				$format = eo_get_event_datetime_format();
			?>

			<article class="event type-event <?php echo esc_attr( implode( ' ',$eo_event_classes ) ); ?>" itemscope itemtype="http://data-vocabulary.org/Event">

    			<header class="event-header-sc">	
    			<h2 class="page-subheading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
    			<div class="event-date">
    			<?php echo eo_format_event_occurrence();?></div>		
    			</header><!-- .event-header -->
   		<div class="event-content-sc" itemprop="description">
            <div class="event-details">			
    		<?php
    		//If it has one, display the thumbnail
    		if ( has_post_thumbnail() ) {
    			the_post_thumbnail( 'thumbnail', array( 'class' => 'attachment-thumbnail eo-event-thumbnail' ) );
    		}
    
    		//If custom meta data available (speaker, series, etc.) show it.	
    		if ( the_meta() ) {
    		    echo the_meta();
    		}
    
    		//A list of event details: venue, categories, tags.
    		echo eo_get_event_meta_list();
    		?>			
    	</div><!-- .event-details -->
		<?php if ( the_excerpt() ) { ?>
		<p><?php the_excerpt(); ?></p>
		<?php } ?>
	</div><!-- .event-content -->
    </article>
	<?php endwhile; ?>

<?php elseif ( ! empty( $eo_event_loop_args['no_events'] ) ) :  ?>

	<div id="<?php echo esc_attr( $id );?>" class="<?php echo esc_attr( $classes );?>" > 
		<p class="eo-no-events" > <?php echo $eo_event_loop_args['no_events']; ?> </p>
	</div>

<?php endif;
