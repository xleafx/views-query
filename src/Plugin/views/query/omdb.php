<?php

namespace Drupal\omdb\Plugin\views\query;

  use Drupal\Core\Render\Element\Value;
  use Drupal\views\Plugin\views\query\QueryPluginBase;
  use Drupal\views\ResultRow;
  use Drupal\views\ViewExecutable;

    /**
     * Fitbit views query plugin which wraps calls to the Fitbit API in order to
     * expose the results to views.
     *
     * @property  value
     * @ViewsQuery(
     *   id = "omdb",
     *   title = @Translation("Omdb"),
     *   help = @Translation("Query against the Fitbit API.")
     * )
     */
    class Omdb extends QueryPluginBase {
      public $value;

      public function ensureTable($table, $relationship = NULL) {
        return '';
      }

      public function addField($table, $field, $alias = '', $params = array()) {
        return $field;
      }

      public function query($get_count = FALSE) {
        dsm('3213');
      }
      /**
       * Builds the necessary info to execute the query.
       */
      public function build(ViewExecutable $view) {
        // Make the query distinct if the option was set.
        if (!empty($this->options['distinct'])) {
          $this->setDistinct(TRUE);
        }

        // Store the view in the object to be able to use it later.
        $this->view = $view;

        $view->initPager();

        // Let the pager modify the query to add limits.
  //      $view->pager->query();
        $view->build_info['query'] = $this->query();
        $view->build_info['count_query'] = $this->query(TRUE);
      }


    public function execute(ViewExecutable $view)  {
//      dsm(array_keys((array) $view));
//      dsm($view);
      $query = $view->build_info['query'];

//      $api = \Drupal::config('omdb.settings')->get('api');
//      $api_url = \Drupal::config('omdb.settings')->get('api_url');
//      $poster_source = \Drupal::config('omdb.settings')->get('poster_source');

      $api = 'https://api.themoviedb.org/3/search/';
      $api_url = 'movie?api_key=1ea13391aba7f6ee274bfb05e3bc2229&language=en-US&query=';
      $poster_source = 'https://image.tmdb.org/t/p/w500';

      $year =
      $row = array();
      $view->pager->preExecute($query);
      $request = json_decode(file_get_contents($api . $api_url . current($view->args) . '&year='. $year .'&page=1'));
//      $poster_request =

      $index = 0;
      foreach ($request->results as $result) {
        $row['index'] = $index++;
//        $row['name'] = $result->name;
        if (!empty($result->poster_path)) {
          $row['poster_path'] = $poster_source . $result->poster_path;
        }
        $row['release_date'] = $result->release_date;
        $row['title'] = $result->title;
        $row['id'] = $result->id;
        $view->result[] = new ResultRow($row);
      }

      $view->pager->query();
      $view->pager->postExecute($view->result);
      $view->pager->updatePageInfo();
      $view->total_rows = $view->pager->getTotalItems();
    }
    private function setDistinct($TRUE) {
    }
  }
