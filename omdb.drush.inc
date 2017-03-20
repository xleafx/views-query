<?php

use \Drupal\node\Entity\Node;

/**
 * Implements hook_drush_command().
 */
function omdb_drush_command() {

  $items = array();
  $items['the-movie-db'] = [
    'description' => 'Create node from API',
    'aliases' => ['tmdb'],
    'options' => [
      'opt_tmdb' => 'Custom option'
    ]
  ];
  return $items;
};

/**
 * @param $title
 *   Select movies from API  by title value query
 *
 * @return mixed
 */
function drush_omdb_search_movies($title) {

  $token = new \Tmdb\ApiToken('1ea13391aba7f6ee274bfb05e3bc2229');
  $client = new \Tmdb\Client($token);

  return $client->getSearchApi()->searchMovies($title);
};

/**
 * Select genres from API by genres id
 */
function drush_omdb_genre() {

  $token  = new \Tmdb\ApiToken('1ea13391aba7f6ee274bfb05e3bc2229');
  $client = new \Tmdb\Client($token);

  $genres = $client->getGenresApi()->getMovieGenres();
};


/**
 * The call back function name in the  following format
 *   drush_{module_name}_{item_id_for_command}()
 *
 * Recording value in the fields from TMDB API and create node
 */
function drush_omdb_the_movie_db() {
  $counter = 0;
  $poster_source = \Drupal::config('omdb.settings')->get('poster_source');
  $position = \Drupal::config('omdb.settings')->get('line');
  $option = drush_get_option('opt_tmdb');
  $file_path = "/home/edge/Documents/movies.list";
  $count = explode(" ", exec('wc -l ' . $file_path));
  $count = $count[0];

  if (!empty($option)) {
    while ($position<$count) {
//      try {
//        $transaction = db_transaction();
        $title = tmdb_read_file($option);
        $movies = drush_omdb_search_movies($title);
        foreach ($movies['results'] as $movie) {

          $query = Drupal::service('entity.query')
            ->get('node')
            ->count()
            ->condition('field_id', $movie['id']);
          $query = $query->execute();

          if (empty($query)) {
            $counter++;
            print "$counter, $title \r";
            $poster = $poster_source . $movie['poster_path'];
//            $original_title = mb_convert_encoding($movie['original_title'], "UTF-8");
//            $overview = mb_convert_encoding($movie['overview'], "UTF-8");
            $node = [
              'type' => 'the_movie_db',
              'title' => $movie['title'],
              'field_id' => [
                'value' => $movie['id']
              ],
              'field_overview' => [
                'value' => $movie['overview']
              ],
              'field_popularity' => [
                'value' => $movie['popularity']
              ],

              'field_release_date' => [
                'value' => $movie['release_date']
              ],
              'field_vote_average' => [
                'value' => $movie['vote_count']
              ]
            ];
            if (!empty($movie['poster_path'])) {
              $node['field_external_poster'] = array(
                'uri' => $poster,
              );
            }

            $node = Node::create($node);
            $node->save();
          }
        }
//      }
//      catch (Exception $e) {
//        $transaction->rollback();
//        file_put_contents('debug', print_r($e->getMessage(), TRUE));
//      }
    }
  }
}

/**
 * @param $option
 *   Read file line to line
 *
 * @return mixed
 *   Return Names of films
 */
function tmdb_read_file($option) {
  $position = \Drupal::config('omdb.settings')->get('line');
  \Drupal::configFactory()->getEditable('omdb.settings')->set('line', $position+1)->save();

  $handle = fopen($option, "r") or die("Couldn't get handle");
  $file = new SplFileObject($option);
  if ($position) {
    $file->seek($position);
  }
  $line = $file->current();

  preg_match('/"(.*?)"/', $file, $line);
  if (!empty($line)) {
    $title = $line[1];
    return $title;
    }
}
