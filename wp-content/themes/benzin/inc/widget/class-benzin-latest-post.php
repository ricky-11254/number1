<?php
class BenZin_Widget_Recent_Posts extends WP_Widget
{
	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct()
	{
		$widget_ops = array(
			'classname'                   => 'benzin_recentesc_html__ntries widget_recentesc_html__ntries',
			'description'                 => __('Your site&#8217;s most recent Posts.', 'benzin'),
			'customize_selective_refresh' => true,
		);
		parent::__construct('benzin-recent-posts', __('Benzin Recent Posts', 'benzin'), $widget_ops);
		$this->alt_option_name = 'widget_recentesc_html__ntries';
	}
	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget($args, $instance)
	{


		extract($args);
		if (!isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}
		$title = (!empty($instance['title'])) ? $instance['title'] : __('Recent Posts', 'benzin');
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);
		$number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
		if (!$number) {
			$number = 5;
		}
		$show_date = isset($instance['show_date']) ? $instance['show_date'] : false;
		$show_comment = isset($instance['show_comment']) ? $instance['show_comment'] : false;
		/**
		 * Filters the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 * @since 4.9.0 Added the `$instance` parameter.
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args     An array of arguments used to retrieve the recent posts.
		 * @param array $instance Array of settings for the current widget.
		 */
		$r = new WP_Query(apply_filters('widget_posts_args', array(
			'meta_query' => array(
				array(
					'key' => '_thumbnail_id'
				)
			),
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		)));
		if ($r->have_posts()) :
?>
			<?php echo $before_widget; ?>
			<?php if ($title) {
				echo $before_title . esc_html($title) . $after_title;
			} ?>
			<?php while ($r->have_posts()) : $r->the_post(); ?>

				<div class="popular-feeds">
					<ul class="popular-post">

						<li>
							<div class="popular-thumb">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail('benzin-sidebar-thumbnail'); ?>
								</a>
							</div>
							<div class="popular-text">
								<h4 class="title">
									<a href="<?php the_permalink(); ?>">
										<?php
										$post_title = get_the_title($r->ID);
										$title      = (!empty($post_title)) ? $post_title : __('(no title)', 'benzin');
										$thetitle = $title; /* or you can use get_the_title() */
										$getlength = strlen($thetitle);
										$thelength = 28;
										echo substr($thetitle, 0, $thelength);
										if ($getlength > $thelength)
											echo "...";
										?>

									</a>
								</h4>
								<?php if ($show_date) : ?>

									<span class="popular-meta"><?php the_time('M j, Y') ?></span>
								<?php endif; ?>
								<br>
								<?php if ($show_comment) : ?>
									<span class="popular-meta"><i class="fas fa-comments-alt"></i>
										<?php
										$comments_number = get_comments_number();
										if ('1' === $comments_number) {
											/* translators: %s: post title */
											printf(_x('1 Comment;', 'comments title', 'benzin'), '');
										} else {
											printf( /* translators: 1: number of comments, 2: post title */_nx('%1$s Comment &ldquo;%2$s&rdquo;', '%1$s Comments', $comments_number, 'comments title', 'benzin'), number_format_i18n($comments_number), '');
										}

										?>

									</span>
								<?php endif; ?>
							</div>
						</li>


					</ul>
				</div>


			<?php endwhile; ?>
			<?php echo $after_widget; ?>
		<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();
		endif;
	}
	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update($new_instance, $old_instance)
	{
		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field($new_instance['title']);
		$instance['number']    = (int) $new_instance['number'];
		$instance['show_date'] = isset($new_instance['show_date']) ? (bool) $new_instance['show_date'] : false;
		$instance['show_comment'] = isset($new_instance['show_comment']) ? (bool) $new_instance['show_comment'] : false;
		return $instance;
	}
	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form($instance)
	{
		$title     = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number    = isset($instance['number']) ? absint($instance['number']) : 5;
		$show_date = isset($instance['show_date']) ? (bool) $instance['show_date'] : false;
		$show_comment = isset($instance['show_comment']) ? (bool) $instance['show_comment'] : false;
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html__('Title:', 'benzin'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<p><label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html__('Number of posts to show:', 'benzin'); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3" />
		</p>

		<p><input class="checkbox" type="checkbox" <?php checked($show_date); ?> id="<?php echo esc_attr($this->get_field_id('show_date')); ?>" name="<?php echo esc_attr($this->get_field_name('show_date')); ?>" />
			<label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>"><?php esc_html__('Display post date?', 'benzin'); ?></label>
		</p>
		<p><input class="checkbox" type="checkbox" <?php checked($show_comment); ?> id="<?php echo esc_attr($this->get_field_id('show_comment')); ?>" name="<?php echo esc_attr($this->get_field_name('show_comment')); ?>" />
			<label for="<?php echo esc_attr($this->get_field_id('show_comment')); ?>"><?php esc_html__('Display commnet?', 'benzin'); ?></label>
		</p>
<?php
	}
}
function benzin_recent_widget_registration()
{
	register_widget('BenZin_Widget_Recent_Posts');
}
add_action('widgets_init', 'benzin_recent_widget_registration');
