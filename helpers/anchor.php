<?php

/**
 * If 25.09.22 Arcane Helper
 * MIT https://helpers.arcane.dev
**/

return function($text, $reference, $attributes = []) {
  if(is_array($attributes)) {
    if(!empty($attributes)) {
      $attributes = array_map(function($attribute, $value) {
        if(($value = trim(!is_null($value) ? $value : ''))) {
          return "{$attribute}=\"{$value}\"";
        }
      }, array_keys($attributes), $attributes);
    }

    $attributes = implode("\x20", $attributes);
  } else {
    $attributes = trim($attributes);
  }

  if($attributes != null) {
    $attributes = "\x20{$attributes}";
  }

  return "<a href=\"{$reference}\"{$attributes}>{$text}</a>";
};

?>