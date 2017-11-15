<?php

/**
 * Accordeon Plugin
 *
 * @author nirusu | Nils Hendriks <info@nirusu.me>
 * @version 1.0.0
 */
kirbytext::$pre[] = function($kirbytext, $text) {

  $text = preg_replace_callback('!\[accordeon(…|\.{3})\sopen\ssummary:.*?\](.*?)\[(…|\.{3})accordeon\]!is', function($matches) use($kirbytext) {

    $columns = preg_split('![\n|\r\n]\+{4}\s+[\n|\r\n]!', $matches[2]);
    $html    = array();

    $summary = preg_split('!\]!', $matches[0]);
    $summary = preg_split('!:!', $summary[0]);

    foreach($columns as $column) {
      $field = new Field($kirbytext->field->page, null, trim($column));
      $html[] = kirbytext($field);
    }

    return '<details class="mdl-accordeon" open><summary role="button" aria-expanded="true">' . $summary[1] . '</summary>' . implode($html) . '</details>';

  }, $text);

  $text = preg_replace_callback('!\[accordeon(…|\.{3})\sclosed\ssummary:.*?\](.*?)\[(…|\.{3})accordeon\]!is', function($matches) use($kirbytext) {

    $columns = preg_split('![\n|\r\n]\+{4}\s+[\n|\r\n]!', $matches[2]);
    $html    = array();
    
    $summary = preg_split('!\]!', $matches[0]);
    $summary = preg_split('!:!', $summary[0]);

    foreach($columns as $column) {
      $field = new Field($kirbytext->field->page, null, trim($column));
      $html[] = kirbytext($field);
    }

    return '<details class="mdl-accordeon"><summary role="button" aria-expanded="false">' . $summary[1] . '</summary>' . implode($html) .'</details>';

  }, $text);

  return $text;

};