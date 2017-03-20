<?php

namespace Drupal\omdb\Plugin\QueueWorker;

use SplFileObject;
use Drupal\node\Entity\Node;
use Drupal\Core\Queue\QueueWorkerBase;

/**
 * A Node Publisher that publishes nodes on CRON run.
 *
 * @QueueWorker(
 *   id = "omdb_import",
 *   title = @Translation("Cron Node Publisher"),
 *   cron = {"time" = 2}
 * )
 */
class NodeCronPlugin extends QueueWorkerBase {

  public function processItem($file) {
    $cron_path = "/home/edge/Documents/movies.list";
    $file = new SplFileObject($cron_path);
    if (!empty($file->line)) {
      $file->seek($file->line);
    }
    $line = $file->current();

    preg_match('/"(.*?)"/', $file, $line);
    if (!empty($line)) {
      $title = $line[1];
    }

    preg_match('/\(([^)]+)\)/', $file, $line);
    if (!empty($line)) {
      $year = $line[1];
    }

    if (!empty($title) && !empty($year)) {
      $node = Node::create([
        'type' => 'node_from_file',
        'title' => $title,
        'field_year' => [
          'value' => $year
        ],
      ]);
      $node->save();
    }
  }

}
