inc/helpers.php
===============

.. php:function:: largo_fb_url_to_username()

   Returns a Facebook username or ID from the URL

   :param string $url: a Facebook url

   :returns: string $he Facebook username or id extracted from the input string

   :since: 0.4

.. php:function:: clean_user_fb_username()

   Cleans a Facebook url to the bare username or id when the user is edited

   Edits $_POST directly because there's no other way to save the corrected username
   from this callback. The action hooks this is used for run before edit_user in
   wp-admin/user-edit.php, which overwrites the user's contact methods. edit_user
   reads from $_POST.

   :param object $user_id: the WP_User object being edited
   :param array $_POST:

   :since: 0.4

   :uses: largo_fb_url_to_username

   :link: https://codex.wordpress.org/Plugin_API/Action_Reference/edit_user_profile_update

   :link: https://codex.wordpress.org/Plugin_API/Action_Reference/personal_options_update

.. php:function:: validate_fb_username()

   Checks that the Facebook URL submitted is valid and the user is followable and causes an error if not

   :uses: largo_fb_url_to_username
   :param $errors $he: error object
   :param bool $update: whether this is a user update
   :param object $user: a WP_User object

   :link: https://codex.wordpress.org/Plugin_API/Action_Reference/user_profile_update_errors

   :since: 0.4

.. php:function:: largo_twitter_url_to_username()

   Returns a Twitter username (without the @ symbol)

   :param string $url: a twitter url

   :returns: string $he twitter username extracted from the input string

   :since: 0.3

.. php:function:: clean_user_twitter_username()

   Cleans a Twitter url or an @username to the bare username when the user is edited

   Edits $_POST directly because there's no other way to save the corrected username
   from this callback. The action hooks this is used for run before edit_user in
   wp-admin/user-edit.php, which overwrites the user's contact methods. edit_user
   reads from $_POST.

   :param object $user_id: the WP_User object being edited
   :param array $_POST:

   :since: 0.4

   :uses: largo_twitter_url_to_username

   :link: https://codex.wordpress.org/Plugin_API/Action_Reference/edit_user_profile_update

   :link: https://codex.wordpress.org/Plugin_API/Action_Reference/personal_options_update

.. php:function:: validate_twitter_username()

   Checks that the Twitter URL is composed of valid characters [a-zA-Z0-9_] and
   causes an error if there is not.

   :param $errors $he: error object
   :param bool $update: whether this is a user update
   :param object $user: a WP_User object

   :uses: largo_twitter_url_to_username

   :link: https://codex.wordpress.org/Plugin_API/Action_Reference/user_profile_update_errors

   :since: 0.4

.. php:function:: largo_youtube_url_to_ID()

   Give it a YouTube URL, it'll give you just the video ID

   :param string $url: a YouTube URL (e.g. - https://www.youtube.com/watch?v=i5vfw5f1CZo)

   :returns: string $ust the video ID (e.g. - i5vfw5f1CZo)

   :since: 0.4

.. php:function:: largo_youtube_iframe_from_url()

   For a given YouTube URL, return an iframe to embed

   :param string $url: a YouTube URL (e.g. - https://www.youtube.com/watch?v=i5vfw5f1CZo)
   :param bool $echo: return or echo the output

   :returns: string $ standard YouTube iframe embed code

   :uses: largo_youtube_url_to_ID

   :since: 0.4

.. php:function:: largo_youtube_image_from_url()

   For a given YouTube URL, return the image url for various thumbnail sizes

   :param string $url: a YouTube URL (e.g. - https://www.youtube.com/watch?v=i5vfw5f1CZo)
   :param string $he: image size you'd like (options are: thumb | small | medium | large)
   :param bool $echo: return or echo the output

   :returns: string $ youtube image url

   :uses: largo_youtube_url_to_ID

   :since: 0.4

.. php:function:: largo_make_slug()

   Transform user-entered text into WP-compatible slugs

   :param string $string: the string to turn into a slug
   :param string $maxLength: the max length for the slug in characters

   :since: 0.4

.. php:function:: largo_get_current_url()

   Get the current URL, including the protocol and host

   :since: 0.5

.. php:function:: largo_first_thumbnail_in_post_array()

   Return the first featured image thumbnail found in a given array of WP_Posts

   Useful if you want to create a thumbnail for a given taxonomy

   :param array $n: array of WP_Post objects to iterate over

   :returns: str|false $he HTML for the image, or false if no images were found.

   :since: 0.5.3

   :uses: largo_has_featured_media

.. php:function:: largo_first_headline_in_post_array()

   Return the first headline link for an array of WP_Posts

   Useful if you want to link to an example post in a series.

   :param array $n: array of WP_Post objects to iterate over

   :returns: str $he HTML for the link

   :since: 0.5.3