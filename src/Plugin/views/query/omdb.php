<?php

namespace Drupal\omdb\Plugin\views\query {

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
      $query = $view->build_info['query'];
      $api = 'https://api.themoviedb.org/3/search/';
      $row = array();
      $view->pager->preExecute($query);
      $request = json_decode(file_get_contents($api . 'company?api_key=1ea13391aba7f6ee274bfb05e3bc2229&query=' . current($view->args) . '&page=1'));
      $index = 0;
      foreach ($request->results as $result) {
        $row['index'] = $index++;
        $row['name'] = $result->name;
//        $row['page'] = $result->page;
        $row['id'] = $result->id;
        $view->result[] = new ResultRow($row);
      }
      $view->pager->query();
      $view->pager->postExecute($view->result);
      $view->pager->updatePageInfo();
      $view->total_rows = $view->pager->getTotalItems();






//      $row['index'] = 0;
////      $row['title'] = $request->Title;
//      $row['id'] = $request->id;
//
//      $view->result[] = new ResultRow($row);

//          $view->result = iterator_to_array($result);
//          array_walk($view->result, function(ResultRow $row, $index) {
//            $row->index = $index;
//          });


//        $query = $view->build_info['query'];
//        $count_query = $view->build_info['count_query'];
//
//        $query->addMetaData('view', $view);
//        $count_query->addMetaData('view', $view);
//
//        if (empty($this->options['disable_sql_rewrite'])) {
//            $base_table_data = Views::viewsData()->get($this->view->storage->get('base_table'));
//            if (isset($base_table_data['table']['base']['access query tag'])) {
//                $access_tag = $base_table_data['table']['base']['access query tag'];
//                $query->addTag($access_tag);
//                $count_query->addTag($access_tag);
//            }
//
//            if (isset($base_table_data['table']['base']['query metadata'])) {
//                foreach ($base_table_data['table']['base']['query metadata'] as $key => $value) {
//                    $query->addMetaData($key, $value);
//                    $count_query->addMetaData($key, $value);
//                }
//            }
//        }
//
//        if ($query) {
//            $additional_arguments = \Drupal::moduleHandler()->invokeAll('views_query_substitutions', array($view));
//
//            // Count queries must be run through the preExecute() method.
//            // If not, then hook_query_node_access_alter() may munge the count by
//            // adding a distinct against an empty query string
//            // (e.g. COUNT DISTINCT(1) ...) and no pager will return.
//            // See pager.inc > PagerDefault::execute()
//            // http://api.drupal.org/api/drupal/includes--pager.inc/function/PagerDefault::execute/7
//            // See https://www.drupal.org/node/1046170.
//            $count_query->preExecute();
//
//            // Build the count query.
//            $count_query = $count_query->countQuery();
//
//            // Add additional arguments as a fake condition.
//            // XXX: this doesn't work, because PDO mandates that all bound arguments
//            // are used on the query. TODO: Find a better way to do this.
//            if (!empty($additional_arguments)) {
//                // $query->where('1 = 1', $additional_arguments);
//                // $count_query->where('1 = 1', $additional_arguments);
//            }
//
//            $start = microtime(TRUE);
//
//            try {
//                if ($view->pager->useCountQuery() || !empty($view->get_total_rows)) {
//                    $view->pager->executeCountQuery($count_query);
//                }
//
//                // Let the pager modify the query to add limits.
//                $view->pager->preExecute($query);
//
//                if (!empty($this->limit) || !empty($this->offset)) {
//                    // We can't have an offset without a limit, so provide a very large limit instead.
//                    $limit  = intval(!empty($this->limit) ? $this->limit : 999999);
//                    $offset = intval(!empty($this->offset) ? $this->offset : 0);
//                    $query->range($offset, $limit);
//                }
//
//                $result = $query->execute();
//                $result->setFetchMode(\PDO::FETCH_CLASS, 'Drupal\views\ResultRow');
//
//                // Setup the result row objects.
//                $view->result = iterator_to_array($result);
//                array_walk($view->result, function(ResultRow $row, $index) {
//                    $row->index = $index;
//                });
//
//                $view->pager->postExecute($view->result);
//                $view->pager->updatePageInfo();
//                $view->total_rows = $view->pager->getTotalItems();
//
//                // Load all entities contained in the results.
//                $this->loadEntities($view->result);
//            }
//            catch (DatabaseExceptionWrapper $e) {
//                $view->result = array();
//                if (!empty($view->live_preview)) {
//                    drupal_set_message($e->getMessage(), 'error');
//                }
//                else {
//                    throw new DatabaseExceptionWrapper("Exception in {$view->storage->label()}[{$view->storage->id()}]: {$e->getMessage()}");
//                }
//            }
//
//        }
//        else {
//            $start = microtime(TRUE);
//        }
//        $view->execute_time = microtime(TRUE) - $start;
    }

    private function setDistinct($TRUE) {
    }
  }
}

