<?php

namespace Drupal\omdb\Plugin\RulesAction;

use Drupal\node\Entity\Node;
use Drupal\rules\Core\RulesActionBase;

/**
 * Provides a 'custom action' action.
 *
 * @RulesAction(
 *   id = "omdb_lastviwed",
 *   label = @Translation("Last Viewed"),
 *   category = @Translation("Custom"),
 *   context = {
 *     "entity" = @ContextDefinition("entity",
 *       label = @Translation("Entity"),
 *       description = @Translation("Specifies the entity, which should be deleted permanently.")
 *     ),
 *   }
 * )
 *
 */
class LastViewed extends RulesActionBase {

  /**
   * Flag that indicates if the entity should be auto-saved later.
   *
   * @var bool
   */
  protected $saveLater = FALSE;

  /**
   * Does something to the user entity.
   *
   * @param \Drupal\node\Entity\Node $node
   * @internal param \Drupal\node\Entity\Node $nodeViewsData The user to take action on.*   The user to take action on.
   */
  protected function doExecute($node) {

//    $dateTime = \DateTime::createFromFormat('Y-m-d','2000-01-30');
//    $newDateString = $dateTime->format('Y-m-d\TH:i:s');
  dsm('123');
//    $date = $node['field_node_last_viewed']->getCreatedTime();
////dsm($date);\Drupal\Core\Form\drupal_set_message()
//
//
//    $date = new DateObject();
//    $node = $this->getContext('data')->getContextData();
//    $node ->setValue($date);

    // execution code
    // you may want to set $this->saveLater based on your use case
  }

  /**
   * {@inheritdoc}
   */
  public function autoSaveContext() {
    if ($this->saveLater) {
      return ['entity'];
    }
    return [];
  }

}
