<?php

/**
 * @file
 * Definition of Drupal\omdb\Plugin\views\field\title
 */
namespace Drupal\omdb\Plugin\views\field;

//use Drupal\Core\Form\FormStateInterface;
//use Drupal\node\Entity\NodeType;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Class Title
 *
 * @ViewsField("omdb_title")
 */
class Title extends FieldPluginBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  public function render(ResultRow $values) {
//    echo '<pre>' . print_r($values, TRUE) . '</pre>';
//    die();
//        $value = $this->getValue($values);

//    dsm($values);
    $output = t("Hello World!");
    return array(
      '#markup' => $values->title // $value['title'],
    );
  }
}
