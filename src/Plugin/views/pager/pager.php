<?php

namespace Drupal\omdb\Plugin\views\pager;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\pager\Full;

/**
 * The plugin to handle custom pager.
 *
 * @ingroup views_pager_plugins
 *
 * @ViewsPager(
 *   id = "api_page",
 *   title = @Translation("Custom Page"),
 *   short_title = @Translation("MPage"),
 *   help = @Translation("Some help text"),
 *   theme = "pager",
 *   register_theme = FALSE
 * )
 */

class Pager extends Full {

  public function query() {
//    if ($this->itemsPerPageExposed()) {
//      $query = $this->view->getRequest()->query;
//      dsm($query);
//      $items_per_page = $query->get('items_per_page');
//      if ($items_per_page > 0) {
//        $this->options['items_per_page'] = $items_per_page;
//      }
//      elseif ($items_per_page == 'All' && $this->options['expose']['items_per_page_options_all']) {
//        $this->options['items_per_page'] = 0;
//      }
//    }
//    if ($this->isOffsetExposed()) {
//      $query = $this->view->getRequest()->query;
//      $offset = $query->get('offset');
//      if (isset($offset) && $offset >= 0) {
//        $this->options['offset'] = $offset;
//      }
//    }

    $limit = $this->options['items_per_page'];
    $offset = $this->current_page * $this->options['items_per_page'] + $this->options['offset'];
    if (!empty($this->options['total_pages'])) {
      if ($this->current_page >= $this->options['total_pages']) {
        $limit = $this->options['items_per_page'];
        $offset = $this->options['total_pages'] * $this->options['items_per_page'];
      }
    }

    $this->view->query->setLimit($limit);
    $this->view->query->setOffset($offset);
  }

}
