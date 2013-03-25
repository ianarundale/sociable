<?php
/**
 * Created by IntelliJ IDEA.
 * User: Ian
 * Date: 18/02/2012
 * Time: 18:23
 * To change this template use File | Settings | File Templates.
 */
class Model_Twitter extends Model_ExternalRequest
{
    private static $user_timeline_url = 'https://api.twitter.com/1/statuses/user_timeline.json?include_entities=true&include_rts=true&count=2&screen_name=';
    private static $tweet_mention_url = 'http://search.twitter.com/search.json?q=';


    public function getMentions($keyword, $limit = 0)
    {
        $cacheName = 'twitter-mention-' . $keyword;
        if ($limit) {
            $cacheName = $cacheName . '-limit-' . $limit;
        }

        $cache = Cache::instance();

        if ($cachedMentions = $cache->get($cacheName, FALSE)) {
            $mentions = $cachedMentions;
        } else {
            $searchUrl = self::$tweet_mention_url . $keyword;
            if ($limit) {
                $searchUrl = $searchUrl . '&rpp=' . $limit;
            }

            $mentions = json_decode($this->curlExternalRequest($searchUrl), $assoc = true);

            foreach ($mentions['results'] as &$tweet) {

                // print_r($tweet); exit;

                $time = Date::span(strtotime($tweet['created_at']));


                $formattedTime = null;

                if ($time['days'] < 1) {
                    if ($time['hours'] < 1) {
                        if ($time['minutes'] < 1) {
                            $formattedTime = 'a few seconds ago';
                        } else {
                            $formattedTime = $time['minutes'] . ' minutes ago';
                        }
                    } else if ($time['hours'] < 2) {
                        $formattedTime = $time['hours'] . ' hour ago';
                    } else {
                        $formattedTime = $time['hours'] . ' hours ago';
                    }
                } else {
                    if ($time['days'] < 2) {
                        $formattedTime = $time['days'] . ' day ago';
                    } else {
                        $formattedTime = $time['days'] . ' days ago';
                    }
                }


                $tweet['time_since_tweet'] = $formattedTime;
            }

            /* Iterate over the results to create twitter objects? */

            $cache->set($cacheName, $mentions);
        }

        return $mentions;
    }

    /**
     * @param $twitterUsername
     * @return array|mixed
     */
    public function getTweets($twitterUsername)
    {
        $cacheName = 'twitter-' . $twitterUsername;
        $cache = Cache::instance();

        if ($cachedTweets = $cache->get($cacheName, FALSE)) {
            $usersTweets = $cachedTweets;
        } else {
            $searchUrl = self::$user_timeline_url . $twitterUsername;
            $usersTweets = json_decode($this->curlExternalRequest($searchUrl));

            /**
             * Iterate over the results to create twitter objects?
             */

            $cache->set($cacheName, $usersTweets);
        }

        return $usersTweets;
    }
}
