<?php
/*
* Wordpress github repos class
*
*/

class WP_github_class extends WP_Widget
{

    function __construct()
    {
        parent::__construct(

            // Base ID of  widget
            'mygithubrepos',

            // Widget name will appear in UI
            __('Github repos', 'ghr_domain'),

            // Widget description
            array('description' => __('Get Github repos', 'ghr_domain'),)
        );
    }


    //frontend display
    public function widget($args, $instance)
    {

        $title = apply_filters('widget_title', $instance['title']);
        $title =  esc_attr($title);
        $userName  = esc_attr($instance['userName']);
        $count  = esc_attr($instance['count']);

        echo $args['before_widget'];
        if (!empty($title)) {
            echo "$args[before_title] $title $args[after_title]";
        }
        echo $this->showRepos($title, $userName, $count);
        echo $args['after_widget'];
    }


    //admin
    public function form($instance)
    {

        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __("Github Repos", 'ghr_domain');
        }

        if (isset($instance['userName'])) {
            $userName = $instance['userName'];
        } else {
            $userName = __("njlcll", 'ghr_domain');
        }

        //get count
        if (isset($instance['count'])) {
            $count = $instance['count'];
        } else {
            $count = 3;
        }
?>
        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title', 'ghr_domain') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" value="<?php echo (esc_html($title)); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('username') ?>"><?php _e('UserName', 'ghr_domain') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('username') ?>" name="<?php echo $this->get_field_name('userName') ?>" value="<?php echo (esc_html($userName)); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('count') ?>"><?php _e('Count', 'ghr_domain') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('count') ?>" name="<?php echo $this->get_field_name('count') ?>" value="<?php echo (esc_html($count)); ?>">
        </p>
<?php

    }

    public function update($newInstance, $oldInstance)
    {
        $instance = array();

        if (!empty($newInstance['title'])) {
            $instance['title'] = wp_filter_nohtml_kses($newInstance['title']);
        } else {
            $instance['title']  = "";
        }
        if (!empty($newInstance['userName'])) {
            $instance['userName'] = wp_filter_nohtml_kses($newInstance['userName']);
        } else {
            $instance['userName']  = "";
        }
        if (!empty($newInstance['count'])) {
            $instance['count'] = wp_filter_nohtml_kses($newInstance['count']);
        } else {
            $instance['count']  = "";
        }

        return $instance;
    }

    function showRepos($title, $userName, $count)
    {
        $json = null;
        $url =  "https://api.github.com/users/" . $userName . "/repos?sort=created&per_page=" . $count;

        $response = wp_remote_get($url);
        try {


            $json = json_decode($response['body']);
        } catch (Exception $ex) {
            $json = null;
            return "An error occured while trying to  to Connect to Github $url";
        } 

        if ($json === null) {
            $output = "Sorry Failed to retrieve any results";
        } else {
            $output = "<ul class='repos'>";
            foreach ($json as $repo) {
                $output .= "
        <li>
            <div class='repo-title'>" . esc_html($repo->name) . "</div>
            <div class='repo-description'>" . esc_html($repo->description) . "</div>
            <div class='repo-link'><a href='". esc_html($repo->html_url)."' target='_blank'>web</div>
        </li> ";
            }
           
        }
        return $output;
    }
}

?>