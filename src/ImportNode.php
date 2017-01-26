<?php

namespace Drupal\omdb;

use Drupal\node\Entity\Node;
use SplFileObject;

class ImportNode {

    public static function progressFile($count, $file_path, &$context) {
        if (empty($context['sandbox'])) {
            $context['sandbox']['progress'] = 0;
            $context['sandbox']['current_number'] = 0;
            $context['sandbox']['max'] = $count;
            $context['results'] = 0;
        }

//        $file_path = range($context['sandbox']['progress'], $context['sandbox']['progress'], 10);

        self::importNode($file_path, $context['sandbox']['progress']);
        $context['sandbox']['progress']++;


            $context['results'] = $context['sandbox']['progress'];
            $context['sandbox']['progress']++;
            $context['message'] = 'Importing Node...';

        if ($context['sandbox']['progress'] != $context['sandbox']['max']) {
            $context['finished'] = $context['sandbox']['progress'] / $context['sandbox']['max'];
        }
    }

    public static function importNode($file_path, $position) {

        $file = new SplFileObject($file_path);
        $file->seek($position);
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

    function importNodeFinishedCallback($success, $results, $operations) {
        // The 'success' parameter means no fatal PHP errors were detected. All
        // other error management should be handled using 'results'.
        if ($success) {
            $message = \Drupal::translation()->formatPlural(
                $results,
                'One post processed.', '@count posts processed.'
            );
        }
        else {
            $message = t('Finished with an error.');
        }
        drupal_set_message($message);
    }
}
